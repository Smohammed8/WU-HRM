<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
