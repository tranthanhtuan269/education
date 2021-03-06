<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Permission extends Model
{
	protected $fillable = ['name', 'route', 'group', 'created_by', 'updated_by'];
 

    public static function getDataForDatatable(){
        $query = Permission::select(
                        'id',
                        'name',
                        'route',
                        'group'
                        );
        return $query;
    }

    public static function deleteMulti($id_list){
        $list = explode(",",$id_list);
        $checkPermission = Permission::whereIn('id', $list);
        return ($checkPermission->delete() > 0);
    }



    public function parent()
    {
        return $this->belongsTo('App\Permission', 'group');
    }
}
