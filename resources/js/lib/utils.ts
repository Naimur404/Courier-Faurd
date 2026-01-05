import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

// Bengali number conversion
export function convertToBengaliNumbers(number: number | string): string {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return number.toString().replace(/[0-9]/g, (digit) => bengaliDigits[parseInt(digit)]);
}

// Format number with commas and convert to Bengali
export function formatBengaliNumber(number: number): string {
    const formattedNumber = Math.round(number).toLocaleString('en-US');
    return convertToBengaliNumbers(formattedNumber);
}

// Get color based on success ratio
export function getColorForRatio(ratio: number): string {
    if (ratio >= 90) return '#10b981'; // Green
    if (ratio >= 70) return '#f59e0b'; // Yellow/Orange
    return '#ef4444'; // Red
}

// Mask phone number
export function maskPhoneNumber(phone: string): string {
    if (!phone || phone.length < 4) return phone;
    const firstPart = phone.substring(0, 3);
    const lastPart = phone.substring(phone.length - 2);
    const maskedPart = '*'.repeat(phone.length - 5);
    return firstPart + maskedPart + lastPart;
}

// Format date in Bengali
export function formatBengaliDate(dateString: string): string {
    const bengaliMonths = [
        'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
        'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
    ];
    
    const date = new Date(dateString);
    const day = convertToBengaliNumbers(date.getDate());
    const month = bengaliMonths[date.getMonth()];
    const year = convertToBengaliNumbers(date.getFullYear());
    
    return `${day} ${month} ${year}`;
}
