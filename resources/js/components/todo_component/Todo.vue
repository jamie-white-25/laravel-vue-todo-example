<template>
  <tr v-show="todo">
    <td class="px-6 py-4 whitespace-nowrap">
      <!-- name -->
      <div class="flex items-center">
        <div class="ml-4">
          <div
            class="text-sm font-medium text-gray-900"
            v-show="editMode === false"
          >
            {{ todo.name }}
          </div>
          <div v-show="editMode === true">
            <div
              class="border-b border-gray-300 focus-within:border-indigo-600"
            >
              <input
                type="text"
                name="name"
                id="name"
                class="
                  block
                  w-full
                  text-sm
                  font-medium
                  border-0 border-b border-transparent
                  bg-gray-white
                  p-0
                  border-indigo-600
                  focus:ring-0
                "
                :placeholder="todo.name"
                v-model="inputs.name"
              />
            </div>
          </div>
        </div>
      </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap">
      <!-- description -->
      <div class="text-sm text-gray-900" v-show="editMode === false">
        {{ todo.description }}
      </div>

      <div v-show="editMode === true">
        <div
          class="
            border-b border-gray-300
            focus-within:border-indigo-600
            max-w-sm
          "
        >
          <input
            type="text"
            name="description"
            id="description"
            class="
              block
              w-full
              text-sm
              font-medium
              border-0 border-b border-transparent
              bg-gray-white
              p-0
              border-indigo-600
              focus:ring-0
            "
            :placeholder="todo.description"
            v-model="inputs.description"
          />
        </div>
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
      <!-- completed -->
      <span
        v-show="editMode === false"
        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
        :class="
          todo.completed == true
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800'
        "
      >
        {{ todo.completed }}
      </span>

      <div v-show="editMode === true">
        <button
          type="button"
          class="
            relative
            inline-flex
            flex-shrink-0
            h-6
            w-11
            border-2 border-transparent
            rounded-full
            cursor-pointer
            transition-colors
            ease-in-out
            duration-200
            focus:outline-none
            focus:ring-2
            focus:ring-offset-2
            focus:ring-indigo-500
          "
          :class="todo.completed ? 'bg-green-200' : 'bg-gray-200'"
          @click="todo.completed = !todo.completed"
          role="switch"
          aria-checked="false"
        >
          <span class="sr-only">Use setting</span>
          <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
          <span
            aria-hidden="true"
            class="
              pointer-events-none
              inline-block
              h-5
              w-5
              rounded-full
              bg-white
              shadow
              transform
              ring-0
              transition
              ease-in-out
              duration-200
            "
            :class="todo.completed ? 'translate-x-5' : 'translate-x-0'"
          ></span>
        </button>
      </div>
    </td>

    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
      <button
        v-show="editMode === false"
        class="text-indigo-600 hover:text-indigo-900"
        @click="editMode = true"
      >
        Edit
      </button>
      <button
        v-show="editMode === true"
        class="text-indigo-600 hover:text-indigo-900"
        @click="updateTodo"
      >
        Save
      </button>
    </td>
  </tr>
</template>

<script>
import axios from "axios";
import { computed, ref } from "vue";
export default {
  name: "Todo",
  props: {
    todo: {
      type: Object,
      required: false,
      default: () => {},
    },
  },
  setup(props, ctx) {
    const todo = computed(() => props.todo);
    const editMode = ref(false);
    const inputs = ref({
      name: "",
      description: "",
    });

    const updateTodo = async () => {
      try {
        const res = await axios.patch(
          process.env.MIX_APP_URL + "/api/todos/" + todo.value.id,
          {
            name: inputs.name,
            description: inputs.description,
            completed: todo.completed,
          }
        );
        console.log(res);
      } catch (error) {
        console.log(error);
      }
      editMode.value = false;
    };

    return { todo, editMode, inputs, updateTodo };
  },
};
</script>

<style>
</style>