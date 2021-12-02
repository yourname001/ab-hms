<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $reception_permission = [
            'room_access',
            'room_show',
            'booking_access',
            'booking_create',
            'booking_show',
            'booking_edit',
        ];
        $admin_permissions = Permission::all();
        $receptionist_permission = [];
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        foreach(Permission::get() as $permission){
            if($permission->title == 'room_access'){
                $receptionist_permission[] = $permission->id;
            }elseif($permission->title == 'room_show'){
                $receptionist_permission[] = $permission->id;
            }elseif($permission->title == 'booking_access'){
                $receptionist_permission[] = $permission->id;
            }elseif($permission->title == 'booking_create'){
                $receptionist_permission[] = $permission->id;
            }elseif($permission->title == 'booking_show'){
                $receptionist_permission[] = $permission->id;
            }elseif($permission->title == 'booking_edit'){
                $receptionist_permission[] = $permission->id;
            }
        }
        /* $reception_permissions = $admin_permissions->filter(function ($permission) {
            // return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 16) != 'room_type_access' && substr($permission->title, 0, 11) != 'room_create';
            return substr($permission->title, 0, 11) == 'room_access' && 
                    substr($permission->title, 0, 9) == 'room_show' &&
                    substr($permission->title, 0, 14) == 'booking_access' &&
                    substr($permission->title, 0, 14) == 'booking_create' &&
                    substr($permission->title, 0, 12) == 'booking_show' &&
                    substr($permission->title, 0, 12) == 'booking_edit';
        }); */
        Role::findOrFail(2)->permissions()->sync($receptionist_permission);
    }
}
