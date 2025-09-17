    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">
</head>
<style>
@keyframes gradient-x {
  0% { background-position: 0% 50%; }
  100% { background-position: 100% 50%; }
}
.animate-gradient-x {
  background-size: 200% 200%;
  animation: gradient-x 6s ease-in-out infinite alternate;
}
</style>
<div class="relative w-full h-40 md:h-56 overflow-hidden z-0">
    <!-- Bannière décorative -->
    <div class="absolute inset-0 bg-gradient-to-r from-black via-red-600 to-orange-400 animate-gradient-x blur-sm opacity-80"></div>
    <!-- Texte Fontwork arrondi et moderne -->
    <h1 class="absolute inset-0 flex items-center justify-center select-none pointer-events-none z-10">
        <span class="text-6xl md:text-8xl font-extrabold tracking-widest text-white rounded-3xl px-8 py-2 bg-black/30 backdrop-blur-md drop-shadow-[0_4px_24px_rgba(0,0,0,0.7)] skew-y-6 hover:skew-y-0 hover:scale-105 transition-all duration-500 font-sans"
              style="font-family: 'Poppins', 'Montserrat', 'Segoe UI', Arial, sans-serif; letter-spacing: .15em; text-shadow: 0 4px 24px #ff4500, 0 2px 8px #000;">
            Rapid<span class="text-orange-400 animate-bounce rounded-full bg-white/20 px-4 ml-2">C3</span>
        </span>
    </h1>
</div>
<head>
