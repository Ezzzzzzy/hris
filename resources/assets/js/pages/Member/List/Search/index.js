import React from 'react';
import { Select } from '../../../../components';

const Search = props => {
	const filter = [
		{ name: 'Incomplete Profile', code: 'incomplete' },
		{ name: 'Complete Profile', code: 'complete' },
		{ name: 'All Members', code: 'all' },
	];

	return (
		<div className="row">
			<div className='col-2' >
				<Select 
					label=''
					optionValue='code'
					selectValue={ props.filter }
					display='name'
					onChange={ e=>props.handleFilter({complete: e.target.value}) }
					options={ filter }
				/>
        	</div>

        	<div className='col-6 offset-4'>
        		<div className='row'>
        			<div className='col-9'>
            			<div className="row right">	
                			<div className="col-10 search-container" >
		                    	<input className="form-control search-input" type="search" placeholder="Search" aria-label="Search"/>
		                    </div>
		                    <div className="col-2 search-container" >
		                    	<button className="btn search-button" type="submit"><i className="fa fa-search"></i></button>	
    						</div>
						</div>
					</div>

					<div className='col-3'>
    					<button className="btn btn-success pull-right" type="submit">+ New Member</button>	
    				</div>
				</div>
        	</div>
		</div>
	)
}

export default Search;