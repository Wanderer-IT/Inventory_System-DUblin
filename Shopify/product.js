function increment(button) {
  const input = button.previousElementSibling; 
  const max = parseInt(input.max);            
  let current = parseInt(input.value);       

  if (current < max) {
    input.value = current + 1;
  } else {
    input.value = max; 
    alert("You've reached the maximum stock!"); 
  }
}

function decrement(button) {
  const input = button.nextElementSibling;     
  const min = parseInt(input.min);             
  let current = parseInt(input.value);         

  if (current > min) {
    input.value = current - 1;
  } else {
    input.value = min; 
  }
}
