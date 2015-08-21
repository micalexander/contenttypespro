# More info at https://github.com/guard/guard#readme

asset_folders = 'assets'

group :development do

	# https://github.com/pferdefleisch/guard-sprockets
	# set sprockets scripts destination and load paths
	guard 'sprockets', :destination => "#{asset_folders}/js", :asset_paths => ["#{asset_folders}/scripts/", 'bower_components/'], :minify => true, :root_file => "#{asset_folders}/js/ctp-script.js" do

		# sprockets will watch and compile javascript files
		watch(%r{#{asset_folders}/.+\.(js)$})
	end

	# https://github.com/guard/guard-coffeescript
	# coffescript files will be watched and compiled to the :output
	guard 'coffeescript', :input => "#{asset_folders}/js/", :output => "#{asset_folders}/js/script.js"

	# check to see if there is a config.rb in the project root
	if File.exists?("config.rb")

		# compile on start.
		puts `compass compile --time --quiet`

		# https://github.com/guard/guard-compass
		# set compass confib.rb path
		guard :compass, configuration_file: 'config.rb', project_path: '.', compile_on_start: true  do

			# compass will continue to watch and compile scss files
			watch(%r{#{asset_folders}/.+\.(css|scss)$})
		end
	else

		puts "\n\033[31m-------> compass is not watching, config.rb file not found in project root\033[0m\n\n"
	end

	# https://github.com/guard/guard-livereload
	guard 'livereload' do

		# watch and reload browser automatically on save
		watch(%r{#{asset_folders}/.+\.(erb|haml|slim|php|css|js)$})
	end

	# check to see if there is a bower.json in the project root
	if File.exists?("bower.json")

		# https://github.com/mickey/guard-bower
		guard :bower do

			# watch for bower.json changes
			watch('bower.json')
		end
	end
end
