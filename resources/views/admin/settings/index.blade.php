<x-app-layout>
    <x-slot:header>System Settings</x-slot>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Configure global application settings and preferences.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            <h3 class="text-lg font-medium text-gray-900">General Information</h3>
            <p class="mt-1 text-sm text-gray-500">Update your academy's basic information and contact details.</p>
        </div>
        <div class="md:col-span-2">
            <x-ui.card>
                <form class="space-y-6">
                    <div>
                        <label class="label">Academy Name</label>
                        <input type="text" class="input" value="German Academy">
                    </div>
                    <div>
                        <label class="label">Contact Email</label>
                        <input type="email" class="input" value="germanacademy@gmail.com">
                    </div>
                    <div>
                        <label class="label">Contact Phone</label>
                        <input type="text" class="input" value="+216 12 345 678">
                    </div>
                    <div class="pt-4 flex justify-end">
                        <button type="button" class="btn-primary text-sm">Save Changes</button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
