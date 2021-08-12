define(['jquery', 'core/modal_factory', 'core/str','core/modal_events', 'core/ajax', 'core/notification'], function($, ModalFactory, String, ModalEvents, Ajax, Notification){
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

            let request = Y .one('.modal-footer');
            footer.setContent('Delete in process…');
            let spinner = M.util.add_spinner(Y, footer);
            spinner.Show();

            Y.log(modal.params);

            
            Ajax.classList([request])[0].done(function(data){
                if(data === true){
                    //redirect to manage page
                    window.location.reload();
                    Y.log('massage was deleted...');
                }else{
                    Notification.addNotification({
                        message: String.get_string('dltmsg_fail','local_message'),
                        type:'error',
                    });
                }
            }).fail(Notification.exception);
        });
    });
});