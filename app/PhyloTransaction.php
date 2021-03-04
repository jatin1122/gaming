<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhyloTransaction extends Model
{
    protected $table = 'phylo_transactions';

    public $guarded = ['created_at', 'updated_at'];
}