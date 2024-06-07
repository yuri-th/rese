import Vue from 'vue';
import StarRating from 'vue-star-rating';

console.log('Vue:', Vue);
console.log(StarRating);

// Vue.component('star-rating', StarRating);
Vue.component('star-rating', StarRating.default || StarRating);

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOMContentLoaded');
    document.querySelectorAll('.star-rating').forEach(function (el, index) {
        console.log('Element:', el, 'Index:', index);
        el.setAttribute('id', `averageStars${index}`);
        new Vue({
            el: `#averageStars${index}`,
            data: {
                selectedRating: parseFloat(el.getAttribute('data-rating')),
                isStarsChanged: false
            },
            methods: {
                updateRating(rating) {
                    this.selectedRating = rating;
                    this.isStarsChanged = true;
                }
            }
        });
    });
});