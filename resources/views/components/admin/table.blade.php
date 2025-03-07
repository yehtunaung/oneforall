<!-- Table Component -->
<div class="rounded-lg shadow-lg bg-white dark:bg-gray-800">
    <div class="lg:overflow-visible md:overflow-visible sm:overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse border-separate border-spacing-0">
            
            <!-- Header Slot (thead) -->
            <thead class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                {{ $header }}
            </thead>

            <!-- Body Slot (tbody) -->
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                {{ $body }}
            </tbody>

        </table>
    </div>
</div>
