function showEmailInput(year, period, code) {
  const email = prompt("Please enter the student's email:");
  if (email && email.length > 0) {
    window.location.href = `population.php?year=${encodeURIComponent(
      year
    )}&period=${encodeURIComponent(period)}&code=${encodeURIComponent(
      code
    )}&email=${encodeURIComponent(email)}`;
  } else {
    alert("Invalid email.");
  }
}

// function showCourseInput(course) {
//   const course = prompt("Please enter the course code:");
//   if (course && course.length > 0) {
    
//     window.location.href = `population.php?year=${encodeURIComponent(
//       year
//     )}&period=${encodeURIComponent(period)}&code=${encodeURIComponent(
//       code
//     )}&course=${encodeURIComponent(course)}`;
//   } else {
//     alert("Invalid course code.");
//   }
// }
