<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobGrade extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'job_grades';
       protected $primaryKey = 'id';
       


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'level_id',
        'start_salary',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine',
        'ceil_salary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'level_id' => 'integer',
    ];

  // Function to get a specific value by ID and column name
  public static function getSalarySheet($id, $columnName)
  {
      // Find the record by ID
      $record = self::find($id);

      // Check if the record exists
      if ($record) {
          // Check if the specified column exists in the table
          if (in_array($columnName, $record->getFillable())) {
              // Return the value of the specified column
              return $record->$columnName;
          }
      }

      // Return a default value or null if the record or column doesn't exist
      return null;
  }



    public function level()
    {
        return $this->belongsTo(Level::class);
    }

}
