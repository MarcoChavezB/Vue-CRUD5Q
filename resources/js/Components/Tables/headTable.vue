<template>
    <thead>
      <tr>
        <th v-for="(header, index) in headers" :key="index" class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
          <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
            {{ header }}
          </p>
        </th>
        <th class="p-4 border-y border-blue-gray-100 bg-blue-gray-50/50">
          <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
            Edit  / Delete
          </p>
        </th>
      </tr>
    </thead>
  </template>
  
  <script>
  export default {
    props: {
      headers: {
        type: Array,
        required: true,
      },
    },
  };
  </script>
  