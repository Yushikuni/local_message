define(['jquery', 'core/modal_factory', 'core/str','core/modal_events'], function($, ModalFactory, String, ModalEvents){
    var trigger = $('.local_message_delete_button');
    ModalFactory.create({
        type:  ModalFactory.types.SAVE_CANCEL,
        title: String.get_string('deltmsg','local_message'),
        body: String.get_string('deltmsg_confirm','local_message'),
        preShowCallback: function(triggerElement, modal){
            triggerElement = $(triggerElement);

            let classString = triggerElement[0].classList[0];
            let messageid = classString.substr(classString.lastIndexOf('local_messageid') + 'local_messageid'.length);

            modal.params = {'messageid':messageid};
            modal.setSaveButtonText(String.get_string('deltmsg','local_message'));
        },
        large:true,
    }, trigger)
    .done(function(modal){
        // Do what you want with your new modal.
        modal.getRoot().done(ModalEvents.save, function(e){
            e.preventDefault();
        });
    });
});