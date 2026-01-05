<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/components/ui/Card.vue';
import { 
    Shield, Users, Clock, TrendingUp, CheckCircle, 
    Target, Eye, Award, Phone, Mail, MapPin
} from 'lucide-vue-next';
</script>

<template>
    <Head>
        <title>About Us - FraudShield বাংলাদেশী কুরিয়ার ফ্রড ডিটেকশন সিস্টেম</title>
        <meta name="description" content="FraudShield সম্পর্কে জানুন - বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম। আমাদের মিশন, দল এবং সেবা সম্পর্কে বিস্তারিত তথ্য।" />
    </Head>
    
    <AppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-primary to-purple-600 text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-6">
                    FraudShield সম্পর্কে জানুন
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto opacity-90">
                    বাংলাদেশের প্রথম কুরিয়ার ফ্রড ডিটেকশন সিস্টেম - আপনার ব্যবসাকে নিরাপদ রাখতে আমরা প্রতিশ্রুতিবদ্ধ
                </p>
                <div class="flex justify-center flex-wrap gap-6 text-lg">
                    <div class="flex items-center">
                        <Shield class="w-6 h-6 mr-2 text-yellow-400" />
                        <span>নিরাপদ যাচাইকরণ</span>
                    </div>
                    <div class="flex items-center">
                        <Users class="w-6 h-6 mr-2 text-yellow-400" />
                        <span>গ্রাহক সুরক্ষা</span>
                    </div>
                    <div class="flex items-center">
                        <Clock class="w-6 h-6 mr-2 text-yellow-400" />
                        <span>২৪/৭ মনিটরিং</span>
                    </div>
                    <div class="flex items-center">
                        <TrendingUp class="w-6 h-6 mr-2 text-yellow-400" />
                        <span>রিয়েল-টাইম ডাটা</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-6">
                            আমাদের লক্ষ্য
                        </h2>
                        <p class="text-muted-foreground text-lg mb-6 leading-relaxed">
                            আমরা অনলাইন বাণিজ্যের জন্য একটি নিরাপদ পরিবেশ তৈরি করতে প্রতিশ্রুতিবদ্ধ যেখানে বিস্তৃত 
                            কুরিয়ার যাচাইকরণ সেবা প্রদান করা হয়। আমাদের লক্ষ্য হল ফ্রড নির্মূল করা এবং গ্রাহক ও 
                            কুরিয়ার সেবার মধ্যে বিশ্বাস তৈরি করা।
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <CheckCircle class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" />
                                <div>
                                    <h3 class="font-semibold text-foreground mb-1">রিয়েল-টাইম যাচাইকরণ</h3>
                                    <p class="text-muted-foreground">কুরিয়ার সত্যতা এবং ডেলিভারি স্ট্যাটাসের তাৎক্ষণিক যাচাই</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <CheckCircle class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" />
                                <div>
                                    <h3 class="font-semibold text-foreground mb-1">বিস্তৃত ডাটাবেস</h3>
                                    <p class="text-muted-foreground">বাংলাদেশের সকল প্রধান কুরিয়ার সার্ভিসের তথ্য</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <CheckCircle class="w-6 h-6 text-green-500 mr-3 mt-1 flex-shrink-0" />
                                <div>
                                    <h3 class="font-semibold text-foreground mb-1">AI-চালিত বিশ্লেষণ</h3>
                                    <p class="text-muted-foreground">উন্নত মেশিন লার্নিং অ্যালগরিদম দ্বারা ফ্রড সনাক্তকরণ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img 
                            src="/assets/banner.jpg" 
                            alt="FraudShield Mission" 
                            class="rounded-2xl shadow-2xl"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-muted/50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
                        আমাদের বৈশিষ্ট্যসমূহ
                    </h2>
                    <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
                        আপনার ব্যবসাকে সুরক্ষিত রাখতে আমাদের অত্যাধুনিক প্রযুক্তি ও সেবাসমূহ
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <Card class="p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4">
                            <Target class="w-8 h-8 text-primary" />
                        </div>
                        <h3 class="text-xl font-semibold mb-2">সঠিক তথ্য</h3>
                        <p class="text-muted-foreground">
                            সবচেয়ে নির্ভুল এবং আপডেটেড কুরিয়ার তথ্য প্রদান
                        </p>
                    </Card>
                    
                    <Card class="p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-green-500/10 rounded-full flex items-center justify-center mb-4">
                            <Eye class="w-8 h-8 text-green-500" />
                        </div>
                        <h3 class="text-xl font-semibold mb-2">স্বচ্ছতা</h3>
                        <p class="text-muted-foreground">
                            গ্রাহক ও বিক্রেতাদের মধ্যে বিশ্বাস তৈরি করা
                        </p>
                    </Card>
                    
                    <Card class="p-6 text-center hover:shadow-lg transition-shadow">
                        <div class="w-16 h-16 mx-auto bg-yellow-500/10 rounded-full flex items-center justify-center mb-4">
                            <Award class="w-8 h-8 text-yellow-500" />
                        </div>
                        <h3 class="text-xl font-semibold mb-2">গুণমান</h3>
                        <p class="text-muted-foreground">
                            সর্বোচ্চ মানের সেবা নিশ্চিত করা
                        </p>
                    </Card>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
                        যোগাযোগ করুন
                    </h2>
                    <p class="text-muted-foreground text-lg">
                        আমাদের সাথে যোগাযোগ করতে দ্বিধা করবেন না
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <Card class="p-6 text-center">
                        <Phone class="w-10 h-10 mx-auto text-primary mb-4" />
                        <h3 class="font-semibold mb-2">ফোন</h3>
                        <p class="text-muted-foreground">+880 1309-092748</p>
                    </Card>
                    
                    <Card class="p-6 text-center">
                        <Mail class="w-10 h-10 mx-auto text-primary mb-4" />
                        <h3 class="font-semibold mb-2">ইমেইল</h3>
                        <p class="text-muted-foreground">support@fraudshieldbd.site</p>
                    </Card>
                    
                    <Card class="p-6 text-center">
                        <MapPin class="w-10 h-10 mx-auto text-primary mb-4" />
                        <h3 class="font-semibold mb-2">ঠিকানা</h3>
                        <p class="text-muted-foreground">চট্টগ্রাম, বাংলাদেশ</p>
                    </Card>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
