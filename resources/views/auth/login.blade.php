@extends('layouts.app')

@section('title', 'Login - FraudShield BD')

@section('additional_styles')
.login-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.login-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><polygon points="36 34 24 34 24 26 36 26"/></g></g></svg>') repeat;
    opacity: 0.1;
}

.glass-card {
    backdrop-filter: blur(16px) saturate(180%);
    background-color: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
}

.dark .glass-card {
    background-color: rgba(31, 41, 55, 0.8);
    border: 1px solid rgba(75, 85, 99, 0.3);
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    animation: float 6s ease-in-out infinite;
}

.floating-shape:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 20%;
    animation-delay: 0s;
}

.floating-shape:nth-child(2) {
    width: 100px;
    height: 100px;
    top: 20%;
    right: 20%;
    animation-delay: 2s;
}

.floating-shape:nth-child(3) {
    width: 60px;
    height: 60px;
    bottom: 20%;
    left: 30%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) translateX(0px);
    }
    33% {
        transform: translateY(-20px) translateX(10px);
    }
    66% {
        transform: translateY(10px) translateX(-10px);
    }
}

.input-field {
    transition: all 0.3s ease;
}

.input-field:focus {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
}

.login-button {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.login-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.login-button:hover::before {
    left: 100%;
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
}
@endsection

@section('content')
<div class="min-h-screen login-bg flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    <!-- Floating Shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    
    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Logo and Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-6 animate-in">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white w-14 h-14 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
            </div>
            <h2 class="text-4xl font-bold text-white mb-2 animate-in">
                স্বাগতম
            </h2>
            <p class="text-xl text-indigo-100 font-medium mb-2">
                FraudShield BD তে
            </p>
            <p class="text-sm text-indigo-200">
                আপনার অ্যাকাউন্টে সাইন ইন করুন
            </p>
        </div>
        
        <!-- Login Form -->
        <div class="glass-card rounded-2xl p-8 animate-in">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white dark:text-gray-200 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-300"></i>
                        ইমেইল ঠিকানা
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        class="input-field w-full px-4 py-3 border border-white/20 rounded-xl bg-white/10 backdrop-blur-sm text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('email') border-red-400 @enderror" 
                        placeholder="আপনার ইমেইল দিন"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-300 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white dark:text-gray-200 mb-2">
                        <i class="fas fa-key mr-2 text-indigo-300"></i>
                        পাসওয়ার্ড
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="current-password" 
                            required 
                            class="input-field w-full px-4 py-3 pr-12 border border-white/20 rounded-xl bg-white/10 backdrop-blur-sm text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent @error('password') border-red-400 @enderror" 
                            placeholder="আপনার পাসওয়ার্ড দিন"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/60 hover:text-white transition-colors"
                        >
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-300 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-white/30 rounded bg-white/10 backdrop-blur-sm"
                        >
                        <label for="remember" class="ml-2 block text-sm text-white/80">
                            আমাকে মনে রাখুন
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-200 hover:text-white transition-colors">
                            পাসওয়ার্ড ভুলে গেছেন?
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <div>
                    <button 
                        type="submit" 
                        class="login-button w-full flex justify-center items-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        সাইন ইন করুন
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center pt-4 border-t border-white/20">
                    <p class="text-sm text-white/70">
                        অ্যাকাউন্ট নেই?
                        <a href="{{ route('register') }}" class="font-medium text-indigo-200 hover:text-white transition-colors ml-1">
                            নতুন অ্যাকাউন্ট তৈরি করুন
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center">
            <p class="text-sm text-indigo-200">
                <i class="fas fa-shield-alt mr-1"></i>
                নিরাপদ এবং এনক্রিপটেড সংযোগ
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Add stagger animation to form elements
    const formElements = document.querySelectorAll('.glass-card input, .glass-card button, .glass-card label');
    formElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
        element.classList.add('animate-in');
    });
});
</script>
@endsection