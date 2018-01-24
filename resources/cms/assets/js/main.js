// /**
//  * Created by xpundel on 08.04.16.
//  */
// if (typeof _facepalm != 'undefined') {
//     _facepalm.on('beforeStart', function () {
//         $(document).on('click', '.form-buttons button.preview', function () {
//             // $('.main-cms-form input:hidden[name*=preview]').val(1);
//             var formData = $('.main-cms-form').serialize() + '&generatePreview=1';
//
//             _facepalm.service('UI').toggleSpinner(true);
//             _facepalm.service('UI').toggleFormButtons(false);
//
//             $.when(
//                 $.post(_facepalm.baseUrl + '/', formData, 'json')
//             ).then(function (result) {
//                 swal({
//                     title: '',
//                     type: '',
//                     html:
//                     '<iframe src="/mailable/?previewId=' + result.previewId + '" style="border:1px solid #ccc" width="900px" height="' + Math.round(window.innerHeight * .7) + '" />',
//                     animation: false,
//                     width: 940,
//                     showCancelButton: false,
//                     confirmButtonColor: '#999',
//                     confirmButtonText: 'Закрыть',
//                 });
//                 _facepalm.service('UI').toggleSpinner(false);
//                 _facepalm.service('UI').toggleFormButtons(true);
//             });
//
//
//             return false;
//         });
//         $(document).on('click', '.form-buttons button.save-and-send', function () {
//
//             var email = $('.row-for-field-letter_to input').val();
//
//             swal({
//                 title: email,
//                 text: "Вы готовы к отправке письма на этот адрес?",
//                 type: 'question',
//                 animation: false,
//                 showCancelButton: true,
//                 confirmButtonColor: '#3085d6',
//                 cancelButtonColor: '#d33',
//                 confirmButtonText: 'Да, отправляем',
//                 cancelButtonText: 'Нет, пока не надо',
//             }).then(function (result) {
//                 if (result) {
//                     _facepalm.service('UI').toggleSpinner(true);
//                     _facepalm.service('UI').toggleFormButtons(false);
//
//                     var formData = $('.main-cms-form').serialize();
//                     $.when(
//                         $.post(_facepalm.baseUrl + '/', formData)
//                     ).then(function (response) {
//                         var id = response || $('.cms-module-form').data('id');
//                         $.post(_facepalm.baseUrl + '/', _.extend({sendLetter: id}, _facepalm.getCsrfTokenParameter())).done(function () {
//                             _facepalm.service('UI').toggleSpinner(false);
//                             _facepalm.service('UI').toggleFormButtons(true);
//
//                             swal({
//                                 title: 'Это успех!',
//                                 type: '',
//                                 text: 'Письмо отправлено на ваш адрес ' + email,
//                                 animation: false,
//                                 // width: 940,
//                                 showCancelButton: false,
//                                 // confirmButtonColor: '#999',
//                                 confirmButtonText: 'Спасибо',
//                             }).then(function () {
//                                 document.location.href = _facepalm.baseUrl;
//                             });
//
//                         });
//                     });
//                 }
//             })
//
//
//             return false;
//         });
//
//
//     })
// }