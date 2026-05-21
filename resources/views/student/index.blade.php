@extends('layouts.app')

@section('content')
<div
  x-data="{
    selectedStudent: null,
    openCreateModal() {
      this.selectedStudent = null;
      window.dispatchEvent(new Event('open-create-modal'));
    },
    openEditModal(item) {
      this.selectedStudent = JSON.parse(JSON.stringify(item));
      window.dispatchEvent(new CustomEvent('open-edit-modal', { detail: item }));
    }
  }"
  x-init="
    @if($errors->any() && session('edit_student_id'))
      openEditModal({
        id: {{ session('edit_student_id') }},
        name: @json(old('name')),
        email: @json(old('email')),
        age: @json(old('age')),
        phone: @json(old('phone', '')),
        status: @json(old('status', 'pending'))
      });
    @elseif($errors->any())
      openCreateModal();
    @elseif(isset($editStudent) && $editStudent)
      openEditModal({
        id: {{ $editStudent->id }},
        name: @json($editStudent->name),
        email: @json($editStudent->email),
        age: {{ $editStudent->age }},
        phone: @json($editStudent->phone ?? ''),
        status: @json($editStudent->status ?? 'pending')
      });
    @endif
  "
  class="max-w-screen-xl mx-auto px-4 md:px-8"
>
  <div class="items-start justify-between md:flex">
    <div class="max-w-lg">
      <h3 class="text-gray-800 text-xl font-bold sm:text-2xl">
        Students
      </h3>
      <p class="text-gray-600 mt-2">
        Manage your students and their information.
      </p>
    </div>
    <div class="mt-3 md:mt-0">
      <button
        type="button"
        @click="openCreateModal()"
        class="inline-block px-4 py-2 text-white duration-150 font-medium bg-indigo-600 rounded-lg hover:bg-indigo-500 active:bg-indigo-700 md:text-sm cursor-pointer"
      >Add Student</button>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
          <p class="text-sm text-gray-500 font-medium">Total Students</p>
          <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalStudents }}</p>
          <p class="text-xs text-emerald-600 mt-2 font-medium">Active database rows</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
          <p class="text-sm text-gray-500 font-medium">Active Clearance</p>
          <p class="text-3xl font-bold text-gray-800 mt-1">{{ $activeClearance }}</p>
          <p class="text-xs text-emerald-600 mt-2 font-medium">No holding penalties</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
          <p class="text-sm text-gray-500 font-medium">Pending Requests</p>
          <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingRequests }}</p>
          <p class="text-xs text-amber-600 mt-2 font-medium">Awaiting check review</p>
      </div>
      <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
          <p class="text-sm text-gray-500 font-medium">Completed</p>
          <p class="text-3xl font-bold text-gray-800 mt-1">{{ $completedClearance }}</p>
          <p class="text-xs text-emerald-600 mt-2 font-medium">Fully cleared users</p>
      </div>
  </div>

  <div class="mt-8 shadow-sm border rounded-lg overflow-x-auto bg-white">
    <table class="w-full table-auto text-sm text-left">
      <thead class="bg-gray-50 text-gray-600 font-medium border-b">
        <tr>
          <th class="py-3 px-6">Name</th>
          <th class="py-3 px-6">Email</th>
          <th class="py-3 px-6">Age</th>
          <th class="py-3 px-6">Status</th>
          <th class="py-3 px-6"></th>
        </tr>
      </thead>
      <tbody class="text-gray-600 divide-y">
        @forelse($students as $student)
          <tr>
            <td class="py-3 px-6 whitespace-nowrap">
              <div class="flex items-center gap-x-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                  {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <span class="text-gray-700 text-sm font-medium">{{ $student->name }}</span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $student->email }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $student->age }}</td>
            
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ $student->status === 'active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                {{ $student->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                {{ $student->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $student->status === 'inactive' ? 'bg-gray-100 text-gray-600' : '' }}
              ">
                {{ ucfirst($student->status ?? 'Pending') }}
              </span>
            </td>
            
            <td class="text-right px-6 whitespace-nowrap">
              <button
                type="button"
                @click="openEditModal({ 
                  id: {{ $student->id }}, 
                  name: '{{ addslashes($student->name) }}', 
                  email: '{{ $student->email }}', 
                  age: {{ $student->age }}, 
                  phone: '{{ $student->phone ?? '' }}',
                  status: '{{ $student->status ?? 'pending' }}'
                })"
                class="py-2 px-3 font-medium text-indigo-600 hover:text-indigo-500 duration-150 hover:bg-gray-50 rounded-lg cursor-pointer"
              >Edit</button>

              <form action="/students/{{ $student->id }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete this record?');">
                @csrf
                @method('DELETE')
                <button
                  type="submit"
                  class="py-2 leading-none px-3 font-medium text-red-600 hover:text-red-500 duration-150 hover:bg-gray-50 rounded-lg cursor-pointer"
                >Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="py-12 text-center text-sm text-gray-400 font-medium">
              No registered records currently found in the system. Click "Add Student" to create one.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Create Modal --}}
  <x-student-modal mode="create" />

  {{-- Edit Modal --}}
  <x-student-modal mode="edit" x-bind:student="selectedStudent" />
</div>
@endsection