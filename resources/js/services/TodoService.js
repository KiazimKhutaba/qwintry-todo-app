

export async function getAllTodos()
{
    const response = await fetch('/api/todos');
    return await response.json();
}

export async function createTodo(data) {
    const response = await fetch('/api/todo', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({user: data})
    })
    return await response.json();
}
