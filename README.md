[GEN SSH KEY FOR JWT AUTH](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#generate-the-ssh-keys)

# Entitées

##Place
####id
####googlePlaceId
[DOC GOOGLE](https://developers.google.com/places/place-id)
####name
Nom du lieu

##Fav
####id 
####name
(ex: maison, école...)
####Place
Jointure avec la table Place, une Fav est forcement lié a une Place
####user
Jointure avec la table User, une Fav est forcement lié a un User

##Vtc
####id
####name
Le nom du vtc
####slug
####indemnification
Prix de base de la course en centimes (lorsque je prend un vtc dès le début on rajoute le prix "indemnification" a la course)
####pricePerKilometer
Prix par kilomètre en centimes
####pricePerMinute
Prix par minute en centimes
####rides
Liste de toutes les courses recherché ou commandé pour ce vtc (si je fais une comparaison de prix sans forcement commander, on verra quand même l'entité Ride ajouté a cette collection)

##Option
####id
####slug

##RideComparison
####id
####rides
Listes de toutes les courses qui sont comparé dans l'entité RideComparison en question (Un RideComparison compare plusieurs Ride)
####maxPrice
Le prix de la course la plus cher (utilisé pour modifier le savingPrice du champs user
####distance
La distance entre le début de la course et la fin
####duration
La durée entre le début de la course et la fin

##Ride
####id
####Vtc
Le Vtc de la course
####Options
La liste des options pour cette course (ex: green, van, berline...)
####startPosition
La Place du début
####endPosition
la Place de la fin
####price
Le prix total de la course
####user
Le User qui a généré cette course
####timeBeforeDeparture
Le temps que va mettre le chauffeur Vtc à arriver au départ (Le filtre temps ici)
####emission
La quantité de CO2 rejeté

##User
####id
####email
####roles
####password
####favs
Listes des Fav d'un User
####savingPrice
Le prix qu'un User a économisé depuis le début
####rides
La liste des courses qu'il a comparé
####firstName
####lastName
####resetToken
Token utilisé dans le form mot de passe oublié