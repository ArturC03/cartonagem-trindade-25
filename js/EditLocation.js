const svg = document.querySelector('svg');
const inputX = document.getElementById('location_x');
const inputY = document.getElementById('location_y');

svg.addEventListener('click', e => {
const { pageX, pageY, currentTarget } = e;
const { left, top } = currentTarget.getBoundingClientRect();
const { scrollX, scrollY } = window;
const x = pageX - left - scrollX;
const y = pageY - top - scrollY;
const diameter = 20;

svg.innerHTML = createCircle({ x, y }, diameter);
});

function createCircle(center, diameter) {
    const color = "FF5733";

    inputX.value = center.x;
    inputY.value = center.y;
    return `<circle cx="${center.x}" cy="${center.y}" r="${diameter/2}" fill="#${color}"></circle>`;
}