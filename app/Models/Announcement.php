<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company_id',
    ];



    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    
    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
