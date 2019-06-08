const dictionary = {
    fr : {
        custom: {
            inputPassword: {
                max: 'Mot de passe trop long',
                min: 'Mot de passe trop court',
                required: 'Veuillez fournir un mot de passe'
            },
            inputUsername: {
                max: "Nom d'utilisateur trop long",
                min: "Nom d'utilisateur trop court",
                required: "Veuillez fournir un nom d'utilisateur"
            },
            shoutOutContentInput: {
                required: 'Message requis',
                max: 'Message trop long',
                min: 'Message trop court',
            },
            cancellationMotivationInput: {
                max: 'Motif trop long',
                min: 'Motif trop court',
                required: 'Veuillez fournir un motif'
            },
            ratingInput: {
                min: 'La notation minimale est de 0',
                max: 'La notation maximale est de 5',
                required: 'Veuillez fournir une notation entre 0 et 5'
            },
            commentInput: {
                min: 'La longueur du commentaire autorisée est dépassée'
            },
            roleInput: {
                max: 'Role trop long',
            },
            wantedTimesPerWeekInput: {
                min: 'Pas de valeur négative autorisée'
            },
            usernameInput: {
                required: 'Nom d\'utilisateur requis',
                max: 'Nom d\'utilisateur trop long',
                min: 'Nom d\'utilisateur trop petit',
            },
            newPasswordInput : {
                max: 'Nouveau mot de passe trop long',
                min: 'Nouveau mot de passe trop petit',
            },
            descriptionInput : {
                max: 'Descirption trop longue'
            },
            emailInput : {
                email: 'Email non valide',
                required : 'Email requis'
            },
            activityCostLimitInput : {
                required : 'veuillez indiquer une valeur',
                min: 'Nombre négatifs non autorisés'
            }

        }
    }

};

export default dictionary;