# Landing Page
###### by Gabriel Tannous

Landing page is an open source project that you can use to easily create landing pages by only filling data in website-data.json

## How To Use

Using the website-data.json you can modify all elements inside this php page.

* Open website-data.json with any editor
* Start editing each element data with what suits you
* First element in the json file is your domain, you will find two examples I'm using "localhost" and "engraving-sydney.000webhostapp.com", which means you can use it in multiple domains by just setting first set of elements as your domains.
* Include this page and all it's elements with your project by just copying it inside your project and navigating to it from any link from your website.

## Elements inside website-data.json
#### First element
| Tags | Explanation |
| ------ | ------ |
| Domain | Your domain |

#### Single Elements:
| Tags | Explanation |
| ------ | ------ |
| favicon | Name of your favicon with extension, example "favicon.png" |
| logo | Name of your logo with extension, example "logo.png" |
| title | Title of your website |
| phone-number | Your Phone number to be displayed on the top header |

#### Banner:
| Tags | Explanation |
| ------ | ------ |
| img | Name of your banner image with extension, example "banner.png" |
| text | Text to be displayed on the banner |

#### Form (Contact Form):
| Tags | Explanation |
| ------ | ------ |
| title | Title of your contact form |
| fields | This contains all the fields in your contact form |
| tag | Element tag of your field, example "input" |
| attributes | This contain all the attributes of the current field |
| type | This is the type of this field, example "text" |
| name | Tthis is the name of this field, example "full-name" |
| id | This is the ID of this field, example "Name" |
| class | This is the classes of this field, example "form-control no-mobile" |
| placeholder | This is the placeholder of this field, example "Enter Your Name"|
| required | Set it as yes or no to make the field required or not, example "yes" |
| mail | This contain the mail information |
| to | Use this to set the receiver email |
| header | Use this to set the header of your email |
| subject | Use this to set the email subject |

#### Sections:
| Tags | Explanation |
| ------ | ------ |
| type | There is three types, "about" "slid" and "specials" |
| background | Set the background image of this section |
| title | This is the title of the section |
| img | This is the name of the image inside the section |
| text | Write foen the text to be displayed in this section |

#### Manufacturers (Use this to advertise for another domains):
| Tags | Explanation |
| ------ | ------ |
| name | This is the name of the domain |
| href | Use this to set the link of the domain |

#### Google (Use this for your analytics and recaptcha):
| Tags | Explanation |
| ------ | ------ |
| gtm-id | Google tag manager id |
| aid | Google analytics id |
| recaptcha-site-key | Site key for recaptcha v3 |
| recaptcha-secret-key | Secret key for recaptcha v3 |

### Todos

 - Add different templates to be chosen from the json file


**Free Project, Hell Yeah!**