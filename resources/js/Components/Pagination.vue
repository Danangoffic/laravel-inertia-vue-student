<script setup>
import { ref, computed } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        required: true
    }
});

const perPage = ref(10)
const currentPage = ref(1)
const totalPages = ref(10)
const items = ref([...Array(100).keys()]) // example data


const pages = computed(() => {
  const pages = []
  for (let i = 1; i <= totalPages.value; i++) {
    pages.push(i)
  }
  return pages
})

function updatePerPage() {
  currentPage.value = 1
}

function prevPage() {
  currentPage.value--
}

function nextPage() {
  currentPage.value++
}

function gotoPage(page) {
  let pageNumber = page.split("=")[1];
  console.log(pageNumber);
  router.visit("/student?page=" + pageNumber,{
    preserveScroll: true
  });
}
</script>


<template>
    <div class="flex justify-center my-4 py-4">
      <div class="flex items-center">
        <span class="ml-2 text-gray-600 text-sm">Showing {{ data.meta.from }} to {{ data.meta.to }} of {{ data.meta.total }} result</span>
      </div>
    </div>
    <div class="block py-4">
      <ul class="flex justify-center">
        <li
            v-for="link in data.meta.links"
            class="bg-transparent"
            >
            <button @click.prevent="gotoPage(link.url)" type="button"
                :disabled="link.active || link.url == null"
                :href="link.url"
                :class="[
                'btn-sm',
                link.active ? 'bg-sky-400 border border-slate-300 hover:bg-sky-500 text-white' : 'bg-gray-50 border border-slate-300 text-gray-600'
                ]"
                v-html="link.label"
            ></button>
        </li>
      </ul>
    </div>
  </template>

