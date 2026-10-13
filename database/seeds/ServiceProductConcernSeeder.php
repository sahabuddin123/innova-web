<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceProductConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Services
        $services = [
            ['title' => 'কম্পিউটার ট্রেনিং', 'description' => 'সবার জন্য পেশাদার কম্পিউটার প্রশিক্ষণ।', 'icon' => 'ph ph-monitor', 'status' => 1],
            ['title' => 'গ্রাফিক ডিজাইন', 'description' => 'সৃজনশীল গ্রাফিক ডিজাইন সেবা।', 'icon' => 'ph ph-paint-brush', 'status' => 1],
            ['title' => 'ওয়েব ডিজাইন ও ডেভেলপমেন্ট', 'description' => 'আধুনিক ওয়েব ডিজাইন ও ডেভেলপমেন্ট।', 'icon' => 'ph ph-globe', 'status' => 1],
            ['title' => 'ডিজিটাল মার্কেটিং', 'description' => 'ডিজিটাল মার্কেটিং ও এসইও সলিউশন।', 'icon' => 'ph ph-chart-line-up', 'status' => 1],
            ['title' => 'অ্যান্ড্রয়েড অ্যাপ ডেভেলপমেন্ট', 'description' => 'কাস্টম অ্যান্ড্রয়েড অ্যাপ ডেভেলপমেন্ট।', 'icon' => 'ph ph-device-mobile', 'status' => 1],
            ['title' => 'ভিডিও এডিটিং', 'description' => 'পেশাদার ভিডিও এডিটিং সেবা।', 'icon' => 'ph ph-film-strip', 'status' => 1],
            ['title' => 'মোশন গ্রাফিক', 'description' => 'মোশন গ্রাফিক ডিজাইন ও অ্যানিমেশন।', 'icon' => 'ph ph-sliders', 'status' => 1],
            ['title' => 'কাস্টম সফটওয়্যার ডেভেলপমেন্ট', 'description' => 'আপনার চাহিদা অনুযায়ী সফটওয়্যার সমাধান।', 'icon' => 'ph ph-gear', 'status' => 1],
            ['title' => 'কনটেন্ট রাইটিং', 'description' => 'আপনার ব্যবসার জন্য কনটেন্ট রাইটিং।', 'icon' => 'ph ph-pencil', 'status' => 1],
        ];

        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }

        // Products
        $products = [
            ['title' => 'স্কুল ম্যানেজমেন্ট সিস্টেম', 'description' => 'School management system', 'icon' => 'ph ph-school', 'status' => 1],
            ['title' => 'হাসপাতাল ম্যানেজমেন্ট সিস্টেম', 'description' => 'Hospital management system', 'icon' => 'ph ph-hospital', 'status' => 1],
            ['title' => 'এইচআরএম সফটওয়্যার', 'description' => 'HRM Software', 'icon' => 'ph ph-users', 'status' => 1],
            ['title' => 'ইনভেন্টরি ম্যানেজমেন্ট', 'description' => 'Inventory Management', 'icon' => 'ph ph-package', 'status' => 1],
            ['title' => 'এমপ্লয়ি পিসি মনিটরিং সিস্টেম', 'description' => 'Employee PC Monitoring System', 'icon' => 'ph ph-monitor', 'status' => 1],
            ['title' => 'অ্যাপয়েন্টমেন্ট ম্যানেজমেন্ট', 'description' => 'Appointment Management', 'icon' => 'ph ph-calendar', 'status' => 1],
            ['title' => 'গার্মেন্টস ম্যানেজমেন্ট', 'description' => 'Garments Managements', 'icon' => 'ph ph-tshirt', 'status' => 1],
            ['title' => 'অ্যাকাউন্টিং সফটওয়্যার', 'description' => 'Accounting Software', 'icon' => 'ph ph-calculator', 'status' => 1],
            ['title' => 'ডিজিটাল অ্যাটেনডেন্স', 'description' => 'Digital Attendance', 'icon' => 'ph ph-fingerprint', 'status' => 1],
            ['title' => 'ডায়াগনস্টিক ম্যানেজমেন্ট', 'description' => 'Diagnostic Management', 'icon' => 'ph ph-flask', 'status' => 1],
            ['title' => 'পয়েন্ট অফ সেল সফটওয়্যার', 'description' => 'Point of Sale Software', 'icon' => 'ph ph-credit-card', 'status' => 1],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }

        // Concerns
        $concerns = [
            ['title' => 'গ্রাহক সন্তুষ্টি', 'description' => 'আমরা সর্বদা গ্রাহকদের সন্তুষ্টিকে প্রাধান্য দেই।', 'icon' => 'ph ph-heart', 'status' => 1],
            ['title' => 'মান নিশ্চিতকরণ', 'description' => 'প্রতিটি প্রজেক্টে উচ্চ মান বজায় রাখা।', 'icon' => 'ph ph-medal', 'status' => 1],
            ['title' => 'সময়মত ডেলিভারি', 'description' => 'নির্ধারিত সময়ে প্রজেক্ট সম্পন্ন করা।', 'icon' => 'ph ph-clock', 'status' => 1],
            ['title' => 'দক্ষ টিম', 'description' => 'অভিজ্ঞ এবং দক্ষ পেশাদার টিম।', 'icon' => 'ph ph-users', 'status' => 1],
        ];

        foreach ($concerns as $concern) {
            \App\Models\Concern::create($concern);
        }

        // Workflows
        $workflows = [
            ['title' => 'রিকোয়ারমেন্ট বিশ্লেষণ', 'description' => 'প্রথমে আপনার প্রয়োজনীয়তা বুঝে নেওয়া হয়।', 'step' => 1, 'icon' => 'ph ph-list-checks', 'status' => 1],
            ['title' => 'ডিজাইন ও প্ল্যানিং', 'description' => 'প্রজেক্টের ডিজাইন এবং প্ল্যান তৈরি করা হয়।', 'step' => 2, 'icon' => 'ph ph-pencil-ruler', 'status' => 1],
            ['title' => 'ডেভেলপমেন্ট', 'description' => 'পেশাদার টিম দ্বারা কোডিং এবং ডেভেলপমেন্ট।', 'step' => 3, 'icon' => 'ph ph-code', 'status' => 1],
            ['title' => 'টেস্টিং', 'description' => 'সম্পূর্ণ সিস্টেম পরীক্ষা এবং মান নিশ্চিতকরণ।', 'step' => 4, 'icon' => 'ph ph-bug-beetle', 'status' => 1],
            ['title' => 'ডেলিভারি', 'description' => 'প্রজেক্ট সম্পন্ন হওয়ার পর গ্রাহকের কাছে হস্তান্তর।', 'step' => 5, 'icon' => 'ph ph-truck', 'status' => 1],
        ];

        foreach ($workflows as $workflow) {
            \App\Models\Workflow::create($workflow);
        }

        $this->command->info('Dummy data seeded successfully!');
    }
}
