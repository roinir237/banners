### Promotional Banners ###

The project implements an example banner system that shows or hides banners based on the client's ip or a display period
that is defined for each banner. Each banner consists therefor just of an id which provides a stable identifier for 
each instance and a display period that can be changed and set for each instance. 
  
I haven't touched on the actual content of each banner because I wasn't sure what would be exactly the context of the 
view and other requirements surrounding it. A naive implementation would save the html content along with the banner 
definition in the db. That might work for the simple case but might get complicated if different versions of the banner 
need to be served (e.g for different types of clients) or if an audit trail is required (e.g to show the banner's creator 
the changes they've made).

I've separated the logic of checking for the clients IP from the banner model definition and placed it in the BannerPresenter 
class. Whereas the display period is defined for each banner and should therefor be an internal property of the model, 
the list of allowed IPs is the same for all banners and therefor can be external to the model. The list of banners to be shown
is given by BannerPresenter#getVisibleBanners which excepts the client's IP as an argument. This method signature is 
appropriate for the scope defined in the task but in other context it might be beneficial to change it to accept no arguments
and for "presentation context" (that might include such things as client platform, request headers, and the client's IP) 
to be passed in the presenter's constructor instead. It would be safe to assume that those parameters will be 
constant over the duration of each use of that presenter (as a new presenter will be constructed for each request from 
the client) so passing them via the constructor will be sensible.

The BannerRepository is the repository for the banners. In this implementation the banners are hard coded as a row of data
(as you might get from querying a SQL db) and are transformed from that representation to the PHP object representation on retrieval.
In a more full implementation the repository could query an external database to get the banner definitions.  
 