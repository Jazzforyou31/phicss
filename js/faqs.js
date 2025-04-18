document.addEventListener('DOMContentLoaded', function() {
    
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    
    if (!faqQuestions.length) return;
    
   
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
          
            const faqItem = this.parentElement;
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.toggle-icon i');
            
            
            faqItem.classList.toggle('active');
            
            
            if (icon) {
                if (faqItem.classList.contains('active')) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                } else {
                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');
                }
            }
        });
    });
    
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const currentFaqItem = this.parentElement;
            
        
            faqQuestions.forEach(otherQuestion => {
                const otherFaqItem = otherQuestion.parentElement;
                const otherIcon = otherQuestion.querySelector('.toggle-icon i');
                
                if (otherFaqItem !== currentFaqItem && otherFaqItem.classList.contains('active')) {
                    otherFaqItem.classList.remove('active');
                    
                    if (otherIcon) {
                        otherIcon.classList.remove('fa-minus');
                        otherIcon.classList.add('fa-plus');
                    }
                }
            });
        });
    });
    
}); 


// $(document).ready(function () {
//     // Open Add FAQ Modal
//     $('#addFaqBtn').on('click', function () {
//         // Load the Add FAQ modal HTML via AJAX
//         $.ajax({
//             url: '../../views/adminModals/addFaqsModal.html',
//             method: 'GET',
//             success: function (data) {
//                 $('body').append(data); // Append the modal to the body
//                 $('#addFaqModal').modal('show'); // Show the modal after it's appended
//             },
//             error: function () {
//                 alert("An error occurred while loading the Add FAQ modal.");
//             }
//         });
//     });

//     // Add FAQ via AJAX
//     $(document).on('submit', '#addFaqForm', function (e) {
//         e.preventDefault();
//         const formData = $(this).serialize();

//         $.ajax({
//             url: '../../views/adminModals/addFaqs.php',
//             method: 'POST',
//             data: formData,
//             success: function (response) {
//                 const res = JSON.parse(response);
//                 if (res.status === 'success') {
//                     alert(res.message);
//                     $('#addFaqModal').modal('hide'); // Hide the modal after success
//                     $('#addFaqForm')[0].reset();
//                     location.reload();
//                 } else {
//                     alert(res.message);
//                 }
//             },
//             error: function () {
//                 alert("An error occurred while adding FAQ.");
//             }
//         });
//     });

//     // Edit FAQ via AJAX
//     $(document).on('click', '.edit-faq', function () {
//         const faqId = $(this).data('id');

//         $.ajax({
//             url: '../../views/adminModals/getFaqById.php',
//             method: 'GET',
//             data: { faq_id: faqId },
//             success: function (response) {
//                 const res = JSON.parse(response);
//                 if (res.status === 'success') {
//                     const faq = res.data;
//                     $.ajax({
//                         url: '../../views/adminModals/editFaqsModal.html',
//                         method: 'GET',
//                         success: function (data) {
//                             $('body').append(data); // Append the modal to the body
//                             // Populate the form with FAQ data
//                             $('#editFaqId').val(faq.faq_id);
//                             $('#editQuestion').val(faq.question);
//                             $('#editAnswer').val(faq.answer);
//                             $('#editFaqModal').modal('show'); // Show the edit modal after it's appended
//                         }
//                     });
//                 } else {
//                     alert(res.message);
//                 }
//             },
//             error: function () {
//                 alert("An error occurred while fetching FAQ.");
//             }
//         });
//     });

//     // Handle editing the FAQ via AJAX
//     $(document).on('submit', '#editFaqForm', function (e) {
//         e.preventDefault();
//         const formData = $(this).serialize();

//         $.ajax({
//             url: 'editFaqs.php',
//             method: 'POST',
//             data: formData,
//             success: function (response) {
//                 const res = JSON.parse(response);
//                 if (res.status === 'success') {
//                     alert(res.message);
//                     $('#editFaqModal').modal('hide');
//                     location.reload();
//                 } else {
//                     alert(res.message);
//                 }
//             },
//             error: function () {
//                 alert("An error occurred while editing FAQ.");
//             }
//         });
//     });

//     // Delete FAQ via AJAX
//     $(document).on('click', '.delete-faq', function () {
//         const faqId = $(this).data('id');
//         if (confirm('Are you sure you want to delete this FAQ?')) {
//             $.ajax({
//                 url: 'deleteFaqs.php',
//                 method: 'POST',
//                 data: { action: 'delete_faq', faq_id: faqId },
//                 success: function (response) {
//                     const res = JSON.parse(response);
//                     if (res.status === 'success') {
//                         alert(res.message);
//                         location.reload();
//                     } else {
//                         alert(res.message);
//                     }
//                 },
//                 error: function () {
//                     alert("An error occurred while deleting FAQ.");
//                 }
//             });
//         }
//     });
// });

