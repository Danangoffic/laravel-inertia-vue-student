<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';

defineProps({
    students: {
        type: Object,
        required: true
    },
    name: {
        type: String
    }
});

const form = useForm({
    name: usePage().props.name
});
const formDelete = useForm({
    method: 'DELETE'
});

const deleteStudent = (route) => {
    router.delete(route);
};

const searchStudents = () => {
    router.visit('/student', {
        data: {
            name: form.name
        }
    });
}
</script>

<template>

    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students List</h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6 space-y-6 mb-4 text-right">
                <!-- Add search form -->
                <form @submit.prevent="searchStudents" class="inline-flex mr-4">
                    <input type="text" v-model="form.name" placeholder="Search students"
                        class="px-2 py-1 border rounded-md mr-1">
                    <button type="submit"
                        class="bg-sky-400 px-2 py-1 text-white hover:bg-sky-500 rounded-md">Search</button>
                </form>
                <Link href="/student/create"
                    class="inline-flex bg-emerald-400 px-2 py-1 hover:bg-emerald-500 text-white rounded-md">Create
                Student
                </Link>
            </div>
        </div>

        <div class="pb-12 pt-4">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <table class="border border-gray-100 w-full border-collapse">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="student in students.data" :key="student.id">
                                <td>{{ student.name }}</td>
                                <td>{{ student.email }}</td>
                                <td>{{ student.class.name }}</td>
                                <td>{{ student.section.name }}</td>
                                <td>{{ student.created_at }}</td>
                                <td class="text-center">
                                    <Link :href="`${student.edit_url}`"
                                        class="inline-flex px-2 py-1 border bg-sky-400 rounded-md text-white hover:bg-sky-500">
                                    Edit</Link>
                                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing" @click="deleteStudent(student.delete_url)">
                                        Delete
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="py-0">
            <div class="w-full mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white shadow sm:rounded-lg">
                    <Pagination :data="students" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
