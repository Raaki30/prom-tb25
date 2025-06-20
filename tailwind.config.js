export default {
    content: [
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/css/**/*.css', // Tambahkan baris ini
    ],
    theme: {
      extend: {
        fontFamily: {
          sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        },
      },
    },
    plugins: [forms],
  };
  