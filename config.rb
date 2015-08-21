require 'sass-globbing'
require 'sass-css-importer'

asset_folders = 'assets'

preferred_syntax      = :sass
http_path             = "/"
css_dir               = "#{asset_folders}/css"
sass_dir              = "#{asset_folders}/sass"
images_dir            = "#{asset_folders}/images"
javascripts_dir       = "#{asset_folders}/scripts"
generated_images_dir  = "#{asset_folders}/img"
output_style          = :expanded
environment           = :development
relative_assets       = true
line_comments         = false
color_output          = false
