

async function request(url, data = {}, method = 'POST')
{
    const response = await fetch(url, {
        method: method,
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });

    return await response.json();
}


export async function getAllTodos()
{
    const response = await fetch('/api/todos');
    return await response.json();
}


export async function createTodo(todo)
{
    return await request('/api/todos', { todo })
}

/**
 *
 * @param todoId {int}
 * @param status {boolean}
 * @returns {Promise<any>}
 */
export async function toggleTodoCompleteStatus(todoId, status)
{
    return await request(`/api/todos/${todoId}`, { status })
}

/**
 *
 * @param todoId {int}
 * @param status {boolean}
 * @returns {Promise<any>}
 */
export async function toggleTodoUrgentStatus(todoId, status)
{
    return await request(`/api/todos/${todoId}`, { status })
}


export async function removeTodo(todoId)
{
    return await request(`/api/todos/${todoId}`, { todoId }, 'DELETE');
}
