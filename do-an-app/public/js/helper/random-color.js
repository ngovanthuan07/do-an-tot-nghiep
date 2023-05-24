export function generateRandomColors(numColors) {
    let colors = [];
    let letters = '0123456789ABCDEF';

    for (let i = 0; i < numColors.length; i++) {
        let color = '#';
        for (let j = 0; j < 6; j++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        colors.push(color);
    }

    return colors;
}
