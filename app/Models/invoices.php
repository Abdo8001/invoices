<?php

namespace App\Models;
use App\Models\sections;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    use HasFactory;
    protected $guarded=[];
    use SoftDeletes;

    public function section(){
        return $this->belongsTo(sections::class);
    }
}
