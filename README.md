### Minimal Blog Site Profile For [ProcessWire 3x](https://processwire.com/) with include new API additions like:
#### [New “Unique” status for pages](https://processwire.com/blog/posts/pw-3.0.127/)
#### [New $page->if() method](https://processwire.com/blog/posts/pw-3.0.126/)
#### [API setting()](https://processwire.com/blog/posts/processwire-3.0.119-and-new-site-updates/#new-functions-api-setting-function)
#### [MarkupRegions](https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/)
#### [FunctionsAPI](https://processwire.com/blog/posts/processwire-3.0.39-core-updates/#new-functions-api)

### How To Install
1. Download the [zip file](https://github.com/rafaoski/site-minimal-blog/archive/master.zip) at Github or clone directly the repo: ```git clone https://github.com/rafaoski/site-minimal-blog.git```
2. Extract the folder **site-minimal-master** into a fresh ProcessWire installation root folder.
3. During the installation of ProcessWire, choose the profile **Minimal - Blog Site Profile for ProcessWire 3x**.

### Basic Info
1. Most of the profile settings and translates are in the ``` _init.php ``` file.
2. Functions can be found in the ``` _func.php ``` file.
3. The entire view is rendered in the ``` _main.php ``` file that uses [markup regions](https://processwire.com/docs/front-end/output/markup-regions/).
4. You can easily add [hooks](https://processwire.com/docs/modules/hooks/) using the ``` ready.php ``` file.
5. Options page added with the new [“Unique”](https://processwire.com/blog/posts/pw-3.0.127/) status, which you can use in this simple way like:
 ``` pages('options')->site_name ```
  ``` pages->get('options')->site_name ```
6. The `Author's`, `Archives` pages use URL segments `(/ authors / {author-name} /)`, `(/ archives / {archive-date} /)`, see `views/blog/blog.php` for more info.
7. For makes navigating faster, the [Turbolinks](https://github.com/turbolinks/turbolinks) script has been added.

#### Additionally, you can use the icon font that are included:
[Feather Icons](https://feathericons.com/)

#### All images ( svg ) on the pages come from:
[Icofont](https://icofont.com/)
[Simpleicons ( ProcessWire Logo ) ](https://simpleicons.org/?q=processwire)

#### References:
[Turbolinks](https://github.com/turbolinks/turbolinks)  
[AddToAny - Universal Sharing Buttons](https://www.addtoany.com/)  

####  License
2019 byHumans under the [MIT license](LICENSE).
