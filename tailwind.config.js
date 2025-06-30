/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      keyframes: {
        // Animasi untuk fade-in
        fadeIn: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        // Animasi pulse-grow untuk tombol
        pulseGrow: {
          '0%, 100%': { transform: 'scale(1)' },
          '50%': { transform: 'scale(1.03)' },
        },
        // Animasi glow untuk logo/teks
        glow: {
          '0%, 100%': { filter: 'drop-shadow(0 0 5px rgba(59, 130, 246, 0.7))' },
          '50%': { filter: 'drop-shadow(0 0 15px rgba(59, 130, 246, 1))', transform: 'translateY(-2px)' },
        },
        aiGlowPulse: {
          '0%, 100%': { 
            boxShadow: '0 0 10px rgba(99, 102, 241, 0.5), 0 0 20px rgba(99, 102, 241, 0.3)',
            transform: 'scale(1)',
          },
          '50%': { 
            boxShadow: '0 0 20px rgba(99, 102, 241, 0.8), 0 0 40px rgba(99, 102, 241, 0.6)',
            transform: 'scale(1.02)',
          },
        },
        // Animasi shimmer untuk kartu
        shimmer: {
          '0%': { backgroundPosition: '-1000px 0' },
          '100%': { backgroundPosition: '1000px 0' },
        },
        // Animasi running border
        runningBorder: {
          '0%': { backgroundPosition: '0% 50%' },
          '100%': { backgroundPosition: '100% 50%' },
        },
        // Animasi bergerak untuk background hero
        heroBackground: {
          '0%': { backgroundPosition: '0% 50%' },
          '100%': { backgroundPosition: '100% 50%' },
        },
        // Animasi data stream
        dataStream: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(100%)' },
        },
        dataStreamVertical: {
          '0%': { transform: 'translateY(0)' },
          '100%': { transform: 'translateY(100%)' },
        },
        // Animasi untuk lingkaran di hero
        blobMove: {
            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
            '25%': { transform: 'translate(20%, -10%) scale(1.1)' },
            '50%': { transform: 'translate(0, 20%) scale(0.9)' },
            '75%': { transform: 'translate(-15%, -15%) scale(1.05)' },
        },
        // Animasi untuk efek teks ketik
        typing: {
          'from': { width: '0' },
          'to': { width: '100%' }
        },
        blinkCaret: {
          'from, to': { borderColor: 'transparent' },
          '50%': { borderColor: 'orange' }
        },
        // NEW: Animasi untuk latar belakang login (partikel/grid)
        loginBackgroundParticles: {
            '0%': { backgroundPosition: '0% 0%' },
            '100%': { backgroundPosition: '200% 200%' }, // Gerakkan jauh untuk efek "mengalir"
        },
        // NEW: Animasi untuk visual panel di sisi kanan
        visualPanelGlow: {
            '0%, 100%': { boxShadow: '0 0 15px rgba(59, 130, 246, 0.4), inset 0 0 5px rgba(59, 130, 246, 0.2)' },
            '50%': { boxShadow: '0 0 30px rgba(59, 130, 246, 0.7), inset 0 0 10px rgba(59, 130, 246, 0.4)' },
        },
        visualPanelWave: {
            '0%, 100%': { transform: 'translate(0, 0)' },
            '25%': { transform: 'translate(5%, -10%)' },
            '50%': { transform: 'translate(10%, 0)' },
            '75%': { transform: 'translate(5%, 10%)' },
        },
        visualPanelPulse: {
            '0%, 100%': { transform: 'scale(1)', opacity: '0.8' },
            '50%': { transform: 'scale(1.02)', opacity: '1' },
        },
      },
      animation: {
        'fade-in': 'fadeIn 0.8s ease-out forwards',
        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
        'pulse-grow': 'pulseGrow 2s infinite ease-in-out',
        'logo-glow': 'glow 3s infinite ease-in-out',
        'ai-core-glow-pulse': 'aiGlowPulse 3s infinite ease-in-out',
        'shimmer-animate': 'shimmer 1.5s infinite linear',
        'running-border': 'runningBorder 3s linear infinite',
        'hero-background-animate': 'heroBackground 30s linear infinite',
        'data-stream-animate': 'dataStream 2s linear infinite',
        'data-stream-vertical-animate': 'dataStreamVertical 2s linear infinite',
        'blob-move-1': 'blobMove 20s infinite ease-in-out alternate',
        'blob-move-2': 'blobMove 25s infinite ease-in-out alternate-reverse',
        'typing': 'typing 3.5s steps(40, end), blinkCaret 0.75s step-end infinite',
        // NEW Animations
        'login-bg-particles': 'loginBackgroundParticles 40s linear infinite',
        'visual-panel-glow': 'visualPanelGlow 3s infinite alternate ease-in-out',
        'visual-panel-wave-1': 'visualPanelWave 20s infinite ease-in-out',
        'visual-panel-wave-2': 'visualPanelWave 15s infinite reverse ease-in-out',
        'visual-panel-pulse': 'visualPanelPulse 2s infinite alternate ease-in-out',
      },
    },
  },
  plugins: [],
};