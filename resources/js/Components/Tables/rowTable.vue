<template>
  <tr>
    <td
      v-for="(value, key) in data"
      :key="key"
      class="p-4 border-b border-blue-gray-50"
    >
      <div
      @click="goTo()"
        v-if="key === 'foto' || key === 'logo'"
        class="flex items-center gap-3"
      >
        <img
          :src="value"
          class="relative inline-block h-12 w-12 !rounded-full border border-blue-gray-50 bg-blue-gray-50/50 object-contain object-center p-1"
        />
      </div>
      <p
        v-else-if="key === 'profesores'"
        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900"
      >
        <select >
          <option v-for="profesor in value" :key="profesor.id" :value="profesor.id">
            {{ profesor.nombre }}
          </option>
        </select>
      </p>

      <p
        v-else-if="key === 'materias'"
        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900"
      >
        <select >
          <option v-for="profesor in value" :key="profesor.id" :value="profesor.id">
            {{ profesor.nombre }}
          </option>
        </select>
      </p>

      
      <p
      @click="goTo()"
        v-else
        class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900"
      >
        {{ value }}
      </p>
    </td>
    <td class="p-4 border-b border-blue-gray-50">
      <buttonsEdit :id="data.id" @click="handleButtonClick" />
    </td>
  </tr>
</template>



<script>
import buttonsEdit from '../buttons.vue';

export default {
  components: {
    buttonsEdit,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  methods: {
    goTo() {
      this.$emit('clickRow', this.data.id);
    },
    handleButtonClick(action) {
      this.$emit('getOption', { id: this.data.id, action });
    },
  },
};
</script>

<style scoped>
    tr{
        transition: background-color 0.2s ease-in-out;
        cursor: pointer;
    }
    tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    tr:nth-child(odd) {
        background-color: #ffffff;
    }
    tr:hover {
        background-color: #f1f1f1;
    }

    
</style>
  