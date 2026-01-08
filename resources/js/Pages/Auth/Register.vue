<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import Button from '@/components/ui/Button.vue'
import Card from '@/components/ui/Card.vue'
import Input from '@/components/ui/Input.vue'
import Label from '@/components/ui/label/Label.vue'

interface Props {
  errors?: Record<string, string>
}

defineProps<Props>()

const form = useForm({
  name: '',
  phone: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
})

const submit = () => {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}
</script>

<template>
  <Head>
    <title>Register - FraudShield BD | রেজিস্ট্রেশন</title>
    <meta name="description" content="FraudShield BD এ অ্যাকাউন্ট তৈরি করুন। কুরিয়ার ফ্রড ডিটেকশন সিস্টেমে যোগ দিন। Create your account." />
    <link rel="canonical" href="https://fraudshieldbd.site/register" />
    <meta name="robots" content="noindex, follow" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
  </Head>

  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Header -->
      <div class="text-center">
        <Link href="/">
          <div class="mx-auto h-16 w-16 bg-primary rounded-lg flex items-center justify-center mb-6 hover:opacity-90 transition-opacity">
            <i class="fas fa-user-plus text-2xl text-white"></i>
          </div>
        </Link>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
          অ্যাকাউন্ট তৈরি করুন
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
          FraudShield BD তে যোগ দিন
        </p>
      </div>
      
      <!-- Registration Form -->
      <Card class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
        <form class="space-y-6" @submit.prevent="submit">
          <!-- Name Field -->
          <div>
            <Label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              পূর্ণ নাম
            </Label>
            <Input 
              id="name" 
              v-model="form.name"
              type="text" 
              autocomplete="name" 
              required 
              :error="form.errors.name"
              placeholder="আপনার পূর্ণ নাম দিন"
            />
            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">
              {{ form.errors.name }}
            </p>
          </div>

          <!-- Phone Field -->
          <div>
            <Label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              মোবাইল নম্বর
            </Label>
            <Input 
              id="phone" 
              v-model="form.phone"
              type="tel" 
              autocomplete="tel" 
              required 
              :error="form.errors.phone"
              placeholder="01XXXXXXXXX"
            />
            <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600 dark:text-red-400">
              {{ form.errors.phone }}
            </p>
          </div>
          
          <!-- Email Field -->
          <div>
            <Label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              ইমেইল ঠিকানা
            </Label>
            <Input 
              id="email" 
              v-model="form.email"
              type="email" 
              autocomplete="email" 
              required 
              :error="form.errors.email"
              placeholder="আপনার ইমেইল দিন"
            />
            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">
              {{ form.errors.email }}
            </p>
          </div>
          
          <!-- Password Field -->
          <div>
            <Label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              পাসওয়ার্ড
            </Label>
            <Input 
              id="password" 
              v-model="form.password"
              type="password" 
              autocomplete="new-password" 
              required 
              :error="form.errors.password"
              placeholder="আপনার পাসওয়ার্ড দিন"
            />
            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600 dark:text-red-400">
              {{ form.errors.password }}
            </p>
          </div>
          
          <!-- Password Confirmation Field -->
          <div>
            <Label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              পাসওয়ার্ড নিশ্চিত করুন
            </Label>
            <Input 
              id="password_confirmation" 
              v-model="form.password_confirmation"
              type="password" 
              autocomplete="new-password" 
              required 
              placeholder="পাসওয়ার্ড আবার দিন"
            />
          </div>

          <!-- Terms and Conditions -->
          <div class="flex items-start">
            <input 
              id="terms" 
              v-model="form.terms"
              type="checkbox" 
              required
              class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded mt-1"
            >
            <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
              আমি 
              <a href="#" class="text-primary hover:opacity-80">সেবার শর্তাবলী</a> 
              এবং 
              <a href="#" class="text-primary hover:opacity-80">গোপনীয়তা নীতি</a>
              তে সম্মত
            </label>
          </div>

          <!-- Register Button -->
          <div>
            <Button 
              type="submit" 
              :disabled="form.processing"
              class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-70"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              অ্যাকাউন্ট তৈরি করুন
            </Button>
          </div>

          <!-- Login Link -->
          <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-600">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              ইতিমধ্যে অ্যাকাউন্ট আছে?
              <Link href="/login" class="font-medium text-primary hover:opacity-80">
                সাইন ইন করুন
              </Link>
            </p>
          </div>
        </form>
      </Card>
    </div>
  </div>
</template>
