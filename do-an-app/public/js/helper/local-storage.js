export function handleLocalStorage(key, value) {
    if (value) {
        // Lưu giá trị vào local storage
        localStorage.setItem(key, JSON.stringify(value));
    } else {
        // Truy vấn giá trị từ local storage
        const storedValue = localStorage.getItem(key);
        return storedValue ? JSON.parse(storedValue) : null;
    }
}
