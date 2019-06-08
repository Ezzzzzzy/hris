<?php

use Faker\Generator as Faker;
use App\Models\DocumentType;

$factory->define(DocumentType::class, function (Faker $faker) {
    static $order = 0;
    
    $document_types = [
        [ 'MDF', 0 ],
        [ 'PMRF', 0 ],
        [ 'Data Privacy Act', 0 ],
        [ 'Insular Life Form', 0 ],
        [ 'Two Pieces of 2x2', 1 ],
        [ 'Two Pieces of 1x1', 1 ],
        [ 'Authority to Deduct', 0 ],
        [ 'Requirements Waiver', 0 ],
        [ 'Employment Contract', 0 ],
        [ 'Membership Agreement', 0 ],
        [ 'Auto Debit Agreement', 0 ],
        [ 'Copy of NBI Clearance', 1 ],
        [ 'Membership Application', 0,],
        [ 'Assignment Confirmation', 0 ],
        [ 'Copy of Pag-ibig Number', 1 ],
        [ 'File Endorsement (MOAIC)', 0 ],
        [ 'Copy of Birth Certificate', 1 ],
        [ 'Copy of Philhealth Number', 1 ],
        [ 'Declaration of Good Health', 0 ],
        [ 'Others (Laptop Policy, etc.)', 0 ],
        [ 'Copy of SSS Digitized ID/E1 Form', 1 ],
        [ 'Copy of Tax Identification Number (TIN) ID', 1 ],
        [ 'Copy of Work Permit/Employment Certificate', 1 ],
        [ 'Copy of Health Certificate and Medical Clearance', 1],
    ];

    return [
        'type_name' => $document_types[$order][0],
        'document_type' => $document_types[$order][1],
        'order' => ++$order,
        'enabled' => 1,
        'last_modified_by' => "Admin"
    ];
});
