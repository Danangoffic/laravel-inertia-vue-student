<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue'
defineProps({
    student: {
        type: Object
    },
    sections: {
        type: Object
    },
    classes: {
        type: Object
    },
    submit_edit: {
        type: String
    }
})
console.log("classes : ", usePage().props.classes);
const form = reactive({
    name: null, email:null, class_id: null, section_id: null
});

const handleSubmit = () => {
    router.post("/student", form);
}
</script>

<template>

    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Students</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <!-- Edit Student Form -->
                    <form class="max-w-md mx-auto p-4 pt-6 pb-8 mb-4 rounded"
                        @submit.prevent="handleSubmit">
                        <h2 class="text-lg font-bold mb-4">Create Student Information</h2>

                        <!-- Name Input -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                            <input
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="name" type="text" v-model="form.name" required>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                            <input
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="email" type="email" v-model="form.email" required>
                        </div>

                        <!-- Section Select -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="section">Class</label>
                            <select required
                                class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="section" v-model="form.class_id">
                                <option value="" selected>Select a Class</option>
                                <option v-for="c in classes.data" :key="c.id" :value="c.id">{{ c.name }}</option>
                            </select>
                        </div>
                        <!-- Section Select -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="section">Section</label>
                            <select required
                                class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="section" v-model="form.section_id">
                                <option value="" selected>Select a section</option>
                                <option v-for="section in sections.data" :value="section.id" :key="section.id">{{
                                    section.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded float-end"
                            type="submit">Create Student</button>
                        <Link href="/student" class="bg-slate-300 hover:bg-slate-500 hover:text-white font-bold py-2 px-4 rounded float-end mr-2">Back</Link>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
