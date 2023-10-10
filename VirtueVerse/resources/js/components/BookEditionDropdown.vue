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
import { testScript, logEditionsKey } from '../test';
import { ref, watchEffect, watch, onMounted, defineExpose } from 'vue';

export default {
  setup() {
    const bookEditionDropdownRef = ref(null);
    const showDropdown = ref(false);
    const selectedEdition = ref('');
    const editions = ref([]);
    const editionsKeyNew = ref('');


    async function getBookEditions(editionsKeNewy) {
      try {
        const query = encodeURIComponent(editionsKeyNew);
        const response = await axios.get(`/book-edition/getBookEditions?editionsKey=${query}`);
        editions.value = response.data.results;
      } catch (error) {
        console.error("Failed sending request:", error);
      }
    }

    const testFunction = ref(() => {
      console.log('Function called from outside the component.');
    });

    
    onMounted(() => {
    })

    watch(editionsKeyNew, async (newVal) => {
      console.log("watching book edition dropdown");
      if (newVal) {
        await getBookEditions();
        showDropdown.value = true; // Show the dropdown after loading data
      } else {
        showDropdown.value = false; // Hide the dropdown when the value is empty
      }
    });

    function toggleDropdown() {
      showDropdown.value = !showDropdown.value;
    }

    function selectEdition(edition) {
      selectedEdition.value = edition.title;
      showDropdown.value = false;
    }

    defineExpose({
      testFunction
    });

    return {
      showDropdown,
      editionsKeyNew,
      selectedEdition,
      editions,
      toggleDropdown,
      selectEdition,
      testFunction,
      bookEditionDropdownRef
    };
  },
};

// function logEditionsKey(key) {
//     console.log(key);
// }
</script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>