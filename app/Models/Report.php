<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Report extends Model
{
    protected $fillable = [
        'type',
        'title',
        'template_name',
        'config',
        'saved',
        'last_modified_by'
    ];

    public function getCreatedAtAttribute($timestamp)
    {
        return Carbon::parse($timestamp)->format('M d, Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'last_modified_by');
    }

    public static function getReports()
    {
        $reports = Report::with(['user:id,name'])->get();

        $reports->each(function ($item) {
            parse_str($item->filters, $filters);
            $item->filters = $filters;

            if ($item->type === "HC") {
                parse_str($item->config, $config);
                $item->config = $config;
            } else {
                $item->config = explode(", ", $item->config);
            }
            $item->file_url = url("/") . "/download/" . $item->title;
        });

        return $reports;
    }

    public static function createReport($validator, $attributes = [])
    {
        // HC = Head Count || ML = Member List
        $report = new static;
        $report->fill($attributes);

        if ($attributes["saved"] === 1) {
            if (!array_key_exists("template_name", $attributes)) {
                $validator->errors()->add(
                    'template_name',
                    'Template name is required if you wish to save the template.'
                );
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        }
        
        $report->filters = http_build_query($attributes["filters"] ? $attributes["filters"] : []);

        if (gettype($attributes["config"]) !== "string") {
            if ($attributes['type'] === "HC") {
                $report->config = http_build_query($attributes["config"]);
            } else {
                $report->config = implode(", ", $attributes["config"]);
            }
        }

        if ($report->save()) {
            $report->user()->associate($attributes['last_modified_by']);
            return $report;
        }

        return false;
    }
}
