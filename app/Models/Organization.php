<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use File;
use Response;
use DB;


class Organization extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mission',
        'vision',
        'motto',
        'logo',
        'web_address',
        'fax',
        'telephone',
        'pobox',
        'seal',
        'president_signature',
        'account_number',
        'header',
        'footer',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'logo' => 'integer',
        'seal' => 'integer',
        'president_signature' => 'integer',
    ];

    public function logo()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function seal()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function presidentSignature()
    {
        return $this->belongsTo(UploadFile::class);
    }

    public function viewStructure($crud = false)
    {

        if (!backpack_user()->can('organization.structure.view')) {
            return null;
        }
        $route = route('hierarchy');
        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="View organization structure"><i class="la la-sitemap"></i> Structure</a>';
    }


    public function treeView($crud = false)
    {

        if (!backpack_user()->can('organization.structure.view')) {
            return null;
        }
        $route = route('hierarchy');
        return '<a class="btn btn-sm btn-link"  href="' . $route . '" data-toggle="tooltip" title="View organization structure"><i class="la la-sitemap"></i> Tree</a>';
    }

 public function getDoc($crud = false)
 {
    $route  = route('structure-pdf');
        return '<a class="btn btn-sm btn-link"  href="'.$route.'" data-toggle="tooltip" title="Download"><i class="la la-download"></i> PDF </a>';
 }

}
