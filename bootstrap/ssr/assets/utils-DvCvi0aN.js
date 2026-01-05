import { clsx } from "clsx";
import { twMerge } from "tailwind-merge";
function cn(...inputs) {
  return twMerge(clsx(inputs));
}
function convertToBengaliNumbers(number) {
  const bengaliDigits = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
  return number.toString().replace(/[0-9]/g, (digit) => bengaliDigits[parseInt(digit)]);
}
function formatBengaliNumber(number) {
  if (number === null || number === void 0 || isNaN(number)) {
    return "০";
  }
  const formattedNumber = Math.round(number).toLocaleString("en-US");
  return convertToBengaliNumbers(formattedNumber);
}
function getColorForRatio(ratio) {
  if (ratio >= 90) return "#10b981";
  if (ratio >= 70) return "#f59e0b";
  return "#ef4444";
}
function maskPhoneNumber(phone) {
  if (!phone || phone.length < 4) return phone;
  const firstPart = phone.substring(0, 3);
  const lastPart = phone.substring(phone.length - 2);
  const maskedPart = "*".repeat(phone.length - 5);
  return firstPart + maskedPart + lastPart;
}
function formatBengaliDate(dateString) {
  const bengaliMonths = [
    "জানুয়ারী",
    "ফেব্রুয়ারী",
    "মার্চ",
    "এপ্রিল",
    "মে",
    "জুন",
    "জুলাই",
    "আগস্ট",
    "সেপ্টেম্বর",
    "অক্টোবর",
    "নভেম্বর",
    "ডিসেম্বর"
  ];
  const date = new Date(dateString);
  const day = convertToBengaliNumbers(date.getDate());
  const month = bengaliMonths[date.getMonth()];
  const year = convertToBengaliNumbers(date.getFullYear());
  return `${day} ${month} ${year}`;
}
export {
  formatBengaliDate as a,
  convertToBengaliNumbers as b,
  cn as c,
  formatBengaliNumber as f,
  getColorForRatio as g,
  maskPhoneNumber as m
};
