<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Students;
use App\Models\Courses;
use App\Models\Review;
use Illuminate\Support\Str;

class DummyStudentReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all courses
        $reviewTexts = [
            'এই কোর্সটি আমার জন্য খুবই উপকারী ছিল! আমি অনেক নতুন স্কিল শিখেছি যা আমার ক্যারিয়ারে সাহায্য করবে।',
            'শিক্ষক ও কোর্স কনটেন্ট অসাধারণ! প্রতিটি ক্লাস খুবই ইন্টারেক্টিভ ছিল।',
            'আমি অনেক কিছু শিখেছি এবং খুবই সন্তুষ্ট। কোর্সটি আমার প্রত্যাশার চেয়েও ভালো ছিল।',
            'ক্লাসের পরিবেশ ও সাপোর্ট চমৎকার! আমি অনেক আত্মবিশ্বাস পেয়েছি।',
            'সবাইকে এই কোর্সটি করার পরামর্শ দিবো। এটি সত্যিই একটি অসাধারণ অভিজ্ঞতা।',
            'শেখার পদ্ধতি সহজ ও কার্যকরী। আমি এখন আমার নিজের প্রজেক্ট শুরু করতে পারছি।',
            'প্র্যাকটিক্যাল ক্লাস ছিল দারুণ। প্রতিটি ক্লাসে নতুন কিছু শিখেছি।',
            'ইন্সট্রাক্টর খুবই হেল্পফুল। তারা সবসময় সাহায্য করতে প্রস্তুত।',
            'ক্যারিয়ার গঠনে অনেক সাহায্য করেছে। আমি এখন একটি ভালো চাকরি পেয়েছি।',
            'আমি খুবই খুশি! এই কোর্সটি আমার জীবনের একটি বড় পরিবর্তন এনেছে।' 
        ];

        $count = 0;
        foreach (Courses::all() as $course) {
            $students = Students::where('course_id', $course->id)->inRandomOrder()->limit(10)->get();
            foreach ($students as $student) {
                if ($count >= 100) break 2; // Increase limit to 100
                Review::create([
                    'student_id' => $student->id,
                    'stdName' => $student->sname,
                    'course' => $course->name,
                    'rating' => rand(4, 5), // Randomize between 4 and 5 for realism
                    'msg' => $reviewTexts[array_rand($reviewTexts)],
                    'image' => $student->image, // Use image path from students table
                    'IsActive' => 1
                ]);
                $count++;
            }
        }
    }
}
