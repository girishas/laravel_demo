<?php
class Patient extends Eloquent {
	
	use SortableTrait ;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patients';

	
	protected $fillable = array('company_id', 'name', 'insurance_id', 'insurance_company', 'code', 'date_from', 'date_to', 'billed_amount', 'paid_amount', 'AR_amount', 'status', 'notes', 'is_deleted', 'created_at', 'updated_at');
	
	public static function validate($input, $id = null) {
		$rules = array(
			'user_id'         => 'required',
			'import_data'     => 'required'
		);
		
		
		$messages = array(
			'user_id.required' 	  	 	=> 'User is required.',
			'import_data.required' 	  	=> 'Excel file is required.'
		);

        return Validator::make($input, $rules, $messages);
	}
	
	public static function update_validate($input, $id = null) {
		$rules = array(
			'name'         		 => 'required',
			'status'    		 => 'required',
		);
		
		
		$messages = array(
			'name.required' 	  	 	=> 'Name is required.',
			'status.required' 	  		=> 'Status is required.',
			'insurance_id.required' 	=> 'Insurance ID is required.',
			'code.required' 	  		=> 'Code is required.',
			'billed_amount.numeric' 	=> 'Allowed numeric values only.',
			'paid_amount.numeric' 	  	=> 'Allowed numeric values only.',
			'AR_amount.numeric' 	  	=> 'Allowed numeric values only.',
		);

        return Validator::make($input, $rules, $messages);
	}
	
	
	public static function export_validate($input){
		$rules = array(
			'user_id'        => 'required'
		);
		
		$messages = array(
			'user_id.required' 	 => 'User is required.'
		);
		return Validator::make($input, $rules, $messages);
	}
	
}
