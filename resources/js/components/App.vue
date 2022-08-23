<template>

    <div class="container mt-5" style="padding-left: 0 !important;">
        <h3><span class="fw-bold text-warning">Qwintry</span> TodoList</h3>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Simple todos -->
            <div class="col py-3" style="border: 1px solid #ddd">

                <p>Todos ({{ simpleTodos.length }})</p>

                <ul v-for="todo in simpleTodos">
                    <li :id="todo.id"
                        :key="todo.id"
                        :class="{ 'text-decoration-line-through': todo['is_done'] }"
                        @click="onTodoClick"
                    >
                        {{ todo.text }}
                        <span class="text-primary" v-if="showTodoActions && (+clickTargetId === +todo.id)">[done] [remove] [move to urgent]</span>
                    </li>
                </ul>

                <input type="text" name="todo" id="todo.new" @keydown.enter="addTodo" placeholder="Type todo and press Enter" />
            </div>

            <!-- Urgent todos -->
            <div class="col py-3" style="border: 1px solid #ddd">

                <p>Todos <span :class="{ 'text-danger': urgentTodos.length > 3}">({{  urgentTodos.length }})</span></p>

                <ul v-for="todo in urgentTodos">
                    <li :key="todo.id" :class="{ 'text-decoration-line-through': todo['is_done'] }">{{ todo.text }}</li>
                </ul>
            </div>

        </div>
    </div>
</template>

<script>

import {getAllTodos} from '../services/TodoService'

export default {
    name: "App",

    data() {
        return {
            allTodos: [],
            showTodoActions: false,
            clickTargetId: 0,
            nextTodoId: -1
        }
    },

    mounted() {
        this.getAllTodos()
    },

    computed: {

        simpleTodos() {
            return this.allTodos.filter(todo => todo['is_urgent'] === 0)
        },

        urgentTodos() {
            return this.allTodos.filter(todo => todo['is_urgent'] === 1)
        }
    },

    methods: {

        getAllTodos() {
            getAllTodos().then(todos => {
                this.allTodos = todos
            })
        },

        removeTodo(id) {
            this.allTodos = this.allTodos.filter(todo => todo.id !== id)
        },

        addTodo(e) {
            // return if value is empty
            if(e.target.value.trim().length === 0)
                return false;

            this.allTodos.push({ id: this.nextTodoId, text: e.target.value, is_done: 1, is_urgent: 1 })
        },

        onTodoClick(e) {
            this.clickTargetId = e.target.id
            this.showTodoActions = !this.showTodoActions
        }
    }
}
</script>

<style scoped>

</style>
