<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Auth;

class Course extends Model
{
    //
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'name', 
        'slug',
        'category_id',
        'price',
        'real_price',
        'from_sale',
        'to_sale',
        'duration',
        'downloadable_count',
        'video_count',
        'student_count',
        'star_count',
        'vote_count',
        'sale_count',
        'view_count',

        'description',
        'will_learn',
        'requirement',
        'level',
        'approx_time',

        'featured',
        'featured_index',
        'promotion',
        'promotion_index',
        'five_stars',
        'four_stars',
        'three_stars',
        'two_stars',
        'one_stars',

        'link_intro',
        'status'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function userRoles()
    {
        return $this->belongsToMany('App\UserRole', 'user_courses');
    }

    public function Lecturers(){
        if($this->userRoles){
            return $this->userRoles()->where('role_id', \Config::get('app.teacher'))->get();
        }else{
            return [];
        }
    }

    public function LecturerActive(){
        if($this->userRoles){
            return $this->userRoles()->where('role_id', \Config::get('app.teacher'))->get();
        }else{
            return [];
        }
    }

    public function units()
    {
    	return $this->hasMany('App\Unit')->orderBy('index');
    }

    public function comments()
    {
        // if(Auth::check()){
        //     $sefl = $this;
        //     if(Helper::getUserRoleOfCourse($sefl->id) != null){
        //         return $this->hasMany('App\CommentCourse')->where('parent_id', 0)->where(
        //             function($q) use ($sefl){
        //                 $q->where('state', 1)
        //                     ->orWhere('user_role_id', Helper::getUserRoleOfCourse($sefl->id)->user_role_id);
        //             })->orderBy('created_at', 'desc');
        //     }
        // }else{
        //     return $this->hasMany('App\CommentCourse')->orderBy('created_at', 'desc');
        // }
        // return $this->hasMany('App\CommentCourse')->where('state', 1);

        // return $this->hasMany('App\CommentCourse')->orderBy('created_at', 'desc');
        $arr_comment_id = \DB::table('comment_courses')
                        ->join('user_roles', 'user_roles.id', '=', 'comment_courses.user_role_id')
                        ->join('users', 'users.id', '=', 'user_roles.user_id')
                        ->where('users.status', 1)
                        ->pluck('comment_courses.id');

        return $this->hasMany('App\CommentCourse')->whereIn('id', $arr_comment_id)->orderBy('created_at', 'desc');

    }

    public function takeComment($from, $take){
        return $this->comments()->where('parent_id', 0)->skip($from)->take($take)->get();
    }

    public function commentOfStudentBought(){
        return $this->comments()->where('parent_id', 0)->get();
    }
    
    public function videos()
    {
    	return $this->belongsToMany('App\Video');
    }

    public function all_videos()
    {
        $units = $this->units;
        $total = 0;
        foreach($units as $unit){
            $total += count($unit->videos);
        }
        return $total;
    }
    
    public function checkCourseNotLearning(){

        if(Auth::check()){
            $list_user_roles = Auth::user()->userRoles[0]->id;
            if($this::has('userRoles', Auth::user()->userRoles[0]->id)->first()){
                return 1;
            }
            return 0;
        }
        //0 means user bought this course 
        return 0;

    }

    public static function acceptMulti($id_list, $status){
        $checkCourse = Course::whereIn('id', $id_list);
        return ($checkCourse->update(['status' => $status]) > 0);
    }

    public static function delMulti($id_list){
        $checkCourse = Course::whereIn('id', $id_list);
        return ($checkCourse->delete() > 0);
    }

    public static function listCourseSpecial($order_by){
        // $order_by = (1 Ban chay) (2 Moi nhat) (3 Ban chay)
        if($order_by == 1){
            return \DB::table('courses')
            ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
            ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
            ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
            ->join('users', 'users.id', '=','user_roles.user_id')
            ->where('teachers.status', 1)
            ->where('courses.status', 1)
            ->select('courses.image', 'courses.name', 'courses.id', 'courses.slug', 'courses.price', 'courses.real_price', 'courses.duration', 'courses.star_count', 'courses.vote_count', 'courses.approx_time', 'courses.five_stars', 'courses.four_stars', 'courses.three_stars', 'courses.two_stars', 'courses.one_stars', 'teachers.id as teacherId', 'user_roles.user_id as userRoleId', 'users.name as author')->orderBy('sale_count', 'desc');
        }elseif($order_by == 2){
            return \DB::table('courses')
            ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
            ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
            ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
            ->join('users', 'users.id', '=','user_roles.user_id')
            ->where('teachers.status', 1)
            ->where('courses.status', 1)
            ->select('courses.image', 'courses.name', 'courses.featured', 'courses.featured_index as featured_index', 'courses.id', 'courses.slug', 'courses.price', 'courses.real_price', 'courses.duration', 'courses.star_count', 'courses.vote_count', 'courses.approx_time', 'courses.five_stars', 'courses.four_stars', 'courses.three_stars', 'courses.two_stars', 'courses.one_stars', 'teachers.id as teacherId', 'user_roles.user_id as userRoleId', 'users.name as author')->orderBy('id', 'desc');
        }else{
            $limitDate = \Carbon\Carbon::now()->subDays(15);
            $sql = "SELECT course_id, count(course_id) FROM orders JOIN order_details ON orders.id = order_details.order_id WHERE created_at > '" . $limitDate->toDateTimeString() ."' group by course_id ORDER BY count(course_id) desc;";
            $results = \DB::select($sql);
            foreach ($results as $key => $result) {
                $course_id_arr[] = $result->course_id;
            }
            return Course::whereIn('id', $course_id_arr)->where('status', 1);
        }
    }

    public static function listCourseCategory($cat_id){
        return \DB::table('courses')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('teachers.status', 1)
        ->where('courses.status', 1)
        ->where('courses.category_id', $cat_id)
        ->select('courses.image', 'courses.name', 'courses.id', 'courses.slug', 'courses.price', 'courses.real_price', 'courses.duration', 'courses.star_count', 'courses.vote_count', 'courses.approx_time', 'courses.five_stars', 'courses.four_stars', 'courses.three_stars', 'courses.two_stars', 'courses.one_stars', 'teachers.id as teacherId', 'user_roles.user_id as userRoleId', 'users.name as author');
    }

    public static function listCourseCategoryNotMe($cat_id, $course_id){
        return \DB::table('courses')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('teachers.status', 1)
        ->where('courses.status', 1)
        ->where('courses.id', '!=', $course_id)
        ->where('courses.category_id', $cat_id)
        ->select('courses.image', 'courses.name', 'courses.id', 'courses.slug', 'courses.price', 'courses.real_price', 'courses.duration', 'courses.star_count', 'courses.vote_count', 'courses.approx_time', 'courses.five_stars', 'courses.four_stars', 'courses.three_stars', 'courses.two_stars', 'courses.one_stars', 'teachers.id as teacherId', 'user_roles.user_id as userRoleId', 'users.name as author');
    }

    public static function listCourseHome(){
        return \DB::table('courses')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('teachers.status', 1)
        ->where('courses.status', 1)
        ->select('courses.image', 'courses.name', 'courses.id', 'courses.slug', 'courses.price', 'courses.real_price', 'courses.duration', 'courses.star_count', 'courses.vote_count', 'courses.approx_time', 'courses.five_stars', 'courses.four_stars', 'courses.three_stars', 'courses.two_stars', 'courses.one_stars', 'teachers.id as teacherId', 'user_roles.user_id as userRoleId', 'users.name as author');
    }

    public static function getCourseOfTeacher($user_id, $user_name){
        return \DB::table('courses')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('users.id', $user_id)
        ->update(['courses.author' => $user_name]);
    }
}
