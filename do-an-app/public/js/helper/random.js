import { v4 as uuidv4 } from 'https://jspm.dev/uuid';

export function checkAndRandomizeId(images, id) {
    // Kiểm tra id đã tồn tại trong mảng images hay chưa
    const idExists = images.some(image => image.id === id);

    if (idExists) {
        // Nếu id đã tồn tại, random lại id mới
        let newId;
        do {
            newId = uuidv4();
        } while (images.some(image => image.id === newId)); // Kiểm tra xem id mới random đã tồn tại trong mảng images chưa

        return newId;
    } else {
        // Nếu id chưa tồn tại, trả về id ban đầu
        return id;
    }
}
