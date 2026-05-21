@props(['mode' => 'create', 'student' => null])

@php
    $isEdit = $mode === 'edit';
    $title = $isEdit ? 'Edit Student' : 'Add Student';
    $submitText = $isEdit ? 'Update' : 'Save';
    $eventName = $isEdit ? 'open-edit-modal' : 'open-create-modal';
    $studentJson = $student ? json_encode($student) : 'null';
    $hasErrors = $errors->any();
    $statusValue = old('status', 'pending');
@endphp

<div x-data="{
    open: false,
    student: {{ $studentJson }},
    formAction: '/students',
    updateForm() {
        if (this.student && this.student.id) {
            this.formAction = '/students/' + this.student.id;
        } else {
            this.formAction = '/students';
        }
    }
}" {{ $attributes }}
    x-on:{{ $eventName }}.window="
        open = true;
        @if($isEdit)
        student = $event.detail || JSON.parse($el.getAttribute('data-student') || 'null');
        @endif
        updateForm();
    "
    x-on:close-modal.window="open = false">
    <template x-if="open">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition.opacity>
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="open = false; $dispatch('close-modal')"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
                    <button type="button" @click="open = false; $dispatch('close-modal')" class="text-gray-400 hover:text-gray-600 transition rounded-lg p-1 hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-6 space-y-4">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            @if($isEdit && !$hasErrors) x-bind:value="student ? student.name : ''" @endif
                            required
                            placeholder="e.g. Juan Dela Cruz"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            @if($isEdit && !$hasErrors) x-bind:value="student ? student.email : ''" @endif
                            required
                            placeholder="e.g. juan@psu.edu.ph"
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                            <input
                                type="number"
                                name="age"
                                value="{{ old('age') }}"
                                @if($isEdit && !$hasErrors) x-bind:value="student ? student.age : ''" @endif
                                required
                                min="1"
                                placeholder="e.g. 21"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('age') ? 'border-red-500' : 'border-gray-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                            >
                            @error('age')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone') }}"
                                @if($isEdit && !$hasErrors) x-bind:value="student ? student.phone : ''" @endif
                                placeholder="e.g. 09123456789"
                                class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                            >
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select
                            name="status"
                            @if($isEdit && !$hasErrors) x-model="student.status" @endif
                            class="w-full px-4 py-2.5 rounded-lg border {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        >
                            <option value="active" @if(!$isEdit || $hasErrors) @selected($statusValue === 'active') @endif>Active</option>
                            <option value="pending" @if(!$isEdit || $hasErrors) @selected($statusValue === 'pending') @endif>Pending</option>
                            <option value="completed" @if(!$isEdit || $hasErrors) @selected($statusValue === 'completed') @endif>Completed</option>
                            <option value="inactive" @if(!$isEdit || $hasErrors) @selected($statusValue === 'inactive') @endif>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="open = false; $dispatch('close-modal')" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                            {{ $submitText }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
