<button {{ $attributes->merge(['type' => 'submit','class' =>'btn inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
