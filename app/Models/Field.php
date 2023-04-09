<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use App\Observers\FieldObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Larapen\Admin\app\Models\Traits\Crud;
use Larapen\Admin\app\Models\Traits\SpatieTranslatable\HasTranslations;

class Field extends BaseModel
{
	use Crud, HasFactory, HasTranslations;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'fields';
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	protected $appends = [/*'options'*/];
	
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'belongs_to',
		'name',
		'type',
		'max',
		'default_value',
		'required',
		'use_as_filter',
		'help',
		'active',
	];
	public $translatable = ['name', 'default_value', 'help'];
	
	/**
	 * The attributes that should be hidden for arrays
	 *
	 * @var array
	 */
	// protected $hidden = [];
	
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	// protected $dates = [];
	
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();
		
		Field::observe(FieldObserver::class);
		
		static::addGlobalScope(new ActiveScope());
	}
	
	public static function fieldTypes()
	{
		return [
			'text'              => 'Text',
			'textarea'          => 'Textarea',
			'checkbox'          => 'Checkbox',
			'checkbox_multiple' => 'Checkbox (Multiple)',
			'select'            => 'Select Box',
			'radio'             => 'Radio',
			'file'              => 'File',
			'url'               => 'URL',
			'number'            => 'Number',
			'date'              => 'Date',
			'date_time'         => 'Date Time',
			'date_range'        => 'Date Range',
			'video'             => 'Video (Youtube, Vimeo)',
		];
	}
	
	public function getNameHtml()
	{
		$currentUrl = preg_replace('#/(search)$#', '', url()->current());
		$url = $currentUrl . '/' . $this->id . '/edit';
		
		$out = '<a href="' . $url . '">' . $this->name . '</a>';
		
		return $out;
	}
	
	public function getTypeHtml()
	{
		$types = self::fieldTypes();
		
		return (isset($types[$this->type])) ? $types[$this->type] : $this->type;
	}
	
	public function optionsBtn($xPanel = false)
	{
		$out = '';
		
		if (isset($this->type) && in_array($this->type, ['select', 'radio', 'checkbox_multiple'])) {
			$url = admin_url('custom_fields/' . $this->id . '/options');
			
			$out .= '<a class="btn btn-xs btn-info" href="' . $url . '">';
			$out .= '<i class="fa fa-cog"></i> ';
			$out .= mb_ucfirst(trans('admin.options'));
			$out .= '</a>';
		}
		
		return $out;
	}
	
	public function addToCategoryBtn($xPanel = false)
	{
		$url = admin_url('custom_fields/' . $this->id . '/categories/create');
		
		$out = '';
		$out .= '<a class="btn btn-xs btn-light" href="' . $url . '">';
		$out .= '<i class="fa fa-plus"></i> ';
		$out .= trans('admin.Add to a Category');
		$out .= '</a>';
		
		return $out;
	}
	
	public function getRequiredHtml()
	{
		if (!isset($this->required)) return false;
		
		return checkboxDisplay($this->required);
	}
	
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
	
	public function options()
	{
		return $this->hasMany(FieldOption::class, 'field_id')
			->orderBy('lft')
			->orderBy('value');
	}
	
	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| ACCESSORS
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
