<template>

    <div class="container mt-5" style="padding-left: 0 !important;">
        <h3><span class="fw-bold text-warning">Qwintry</span> TodoList</h3>
    </div>

    <div class="container mt-4">
        <div class="row">

            <!-- Simple todos -->
            <div class="col-md-6 py-3" style="border: 1px solid #ddd">

                <p>Todos ({{ simpleTodos.length }})</p>

                <ul>
                    <li :id="todo.id"
                        :key="todo.id"
                        :class="{ 'text-decoration-line-through': todo['is_done'], 'todo-item__link': true }"
                        v-for="todo in simpleTodos"
                        @click="contentVisible === todo.id ? contentVisible = false : contentVisible = todo.id">

                        {{ todo.text }}

                        <span class="text-primary" v-show="contentVisible === todo.id">
                            <span @click="makeTodoCompleted(todo.id)">{{ todo['is_done'] ? '[done]' : '[complete]' }}</span>
                            <span @click="removeTodo(todo.id)">[remove]</span>
                            <span @click="moveToUrgent(todo.id)">[move to urgent]</span>
                        </span>
                    </li>
                </ul>

                <input type="text" name="todo" id="todo.new" @keydown.enter="addTodo" placeholder="Type todo and press Enter" />
            </div>

            <!-- Urgent todos -->
            <div class="col-md-6 py-3" style="border: 1px solid #ddd">

                <p>Todos <span :class="{ 'text-danger': urgentTodos.length >= 3}">({{  urgentTodos.length }})</span></p>

                <ul>
                    <li :id="todo.id"
                        :key="todo.id"
                        :class="{ 'text-decoration-line-through': todo['is_done'], 'todo-item__link': true }"
                        v-for="todo in urgentTodos"
                        @click="contentVisible === todo.id ? contentVisible = false : contentVisible = todo.id">

                        {{ todo.text }}

                        <span class="text-primary" v-show="contentVisible === todo.id">
                            <span @click="makeTodoCompleted(todo.id)">{{ todo['is_done'] ? '[done]' : '[complete]' }}</span>
                            <span @click="removeTodo(todo.id)">[remove]</span>
                            <span @click="moveToUrgent(todo.id)">[move to simple]</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</template>

<script>

import {getAllTodos, createTodo, removeTodo, toggleTodoCompleteStatus, toggleTodoUrgentStatus} from '../services/TodoService'

export default {
    name: "App",

    data() {
        return {
            allTodos: [],
            contentVisible: false
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

        getAllTodos()
        {
            getAllTodos().then(todos => {
                this.allTodos.push(todos)
            });
        },

        removeTodo(id)
        {
            this.allTodos = this.allTodos.filter(todo => todo.id !== id)

            removeTodo(id).then(console.log)
        },


        addTodo(e)
        {
            // return if value is empty
            if(e.target.value.trim().length === 0)
                return false;

            const clientTodo = { text: e.target.value, is_done: 0, is_urgent: 0 }

            createTodo(clientTodo).then(({ todo }) => {
                this.allTodos.push(todo);
                e.target.value = "";
            });
        },


        makeTodoCompleted(id)
        {
            this.allTodos = this.allTodos.map(todo => {

                if(+todo.id === +id) {
                    todo.is_done = todo.is_done ? 0 : 1;
                    toggleTodoCompleteStatus(todo.id, todo.is_done)
                }

                return todo;
            });
        },

        moveToUrgent(id)
        {
            this.allTodos = this.allTodos.map(todo => {

                if(+todo.id === +id) {
                    todo.is_urgent = todo.is_urgent ? 0 : 1;
                    toggleTodoUrgentStatus(todo.id, todo.is_urgent)
                }

                return todo;
            });
        }
    }
}
</script>

<style scoped>

    .todo-item__link {
        cursor: pointer;
        position: relative;
    }

    .todo-item__link .text-primary {
        position: absolute;
        padding-left: 10px;
    }

    .todo-item__link:hover {
        text-decoration: underline;
    }
</style>
