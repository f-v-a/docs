const colors = require('tailwindcss/colors')
module.exports = {
  darkMode: 'class',
  presets: [require('./vendor/wireui/wireui/tailwind.config.js')],
  content: [
    './app/Http/Livewire/**/*.php',
    './app/View/**/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './storage/framework/views/*.php',
    './storage/framework/views/**/*.blade.php',
    './vendor/wireui/wireui/resources/**/*.blade.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/View/**/*.php',
  ],
  theme: {
    extend: {
      boxShadow: {
        soft: '3px 3px 16px #446b8d33'
      },
      zIndex: {
        '55': '55',
        '60': '60'
      },
      spacing: {
        '18': '4.5rem',
        '72': '18rem',
        '84': '21rem',
        '96': '24rem'
      },
      screens: {
        '3xl': '1600px',
        '4xl': '2560px'
      },
      maxWidth: {
        '8xl': '90rem',
        '9xl': '95rem'
      },
      colors: {
                primary: colors.indigo,
                secondary: colors.gray,
                positive: colors.emerald,
                negative: colors.red,
                warning: colors.amber,
                info: colors.blue,
            },
    }
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/forms') ({
      strategy: 'class',
    }),
    require('@tailwindcss/typography'),
    
  ]
}
