<template>
    <div class="relative">
      <input
        type="text"
        v-model="selectedEdition"
        @click="toggleDropdown"
        placeholder="Search or select a book edition"
        class="border rounded py-2 px-3 w-full cursor-pointer"
      />
      <ul
        v-if="showDropdown"
        class="absolute left-0 mt-2 w-full bg-white border rounded shadow-md max-h-48 overflow-y-auto z-10"
      >
        <li
          v-for="edition in editions"
          :key="edition.id"
          @click="selectEdition(edition)"
          class="p-2 border-b hover:bg-gray-100 cursor-pointer"
        >
          <div class="edition-title font-bold text-lg mb-1">{{ edition.title }}</div>
          <div class="edition-pages text-gray-600 text-sm mb-1">
            Total pages: {{ edition.pages || 'unknown' }}
          </div>
          <div class="edition-isbn text-gray-600 text-sm">
            ISBN number: {{ edition.isbn || 'unknown' }}
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showDropdown: false,
        selectedEdition: '',
        editions: [], // Populate this with your book edition data
      };
    },
    methods: {
      toggleDropdown() {
        this.showDropdown = !this.showDropdown;
      },
      selectEdition(edition) {
        this.selectedEdition = edition.title;
        this.showDropdown = false;
  
        // Perform any additional actions when an edition is selected
        // You can emit an event to the parent component if needed
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>