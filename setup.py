#!/usr/bin/env python
import os
import sys
import platform


"""
main

Configures a new Chameleon project and performs the setup of its Apache
virtual host and rewrite module.

return 0 : success
return 1 : general fail
return 5 : insufficent priviledges
"""
def main():
    exit_code = 0
    config = {}

    if (admin_or_root()):
        config['platform']     = platform.system().lower()
        config['proj_name']    = ask_name('project')
        config['default_view'] = ask_name('view')

        if (config['platform'] == 'linux'):
            config['dist'] = platform.linux_distribution()[0].lower()

        set_apache_locations(config)
        print (config)
    else:
        print('Insufficent Priviledges\nPlease run as root or admin user.')
        exit_code = 5
    
    # Create a Virtual Host for Project.
    
    # See About Enabling Rewrite Module.

    # Create a git Branch

    # Create Config for the Project.
    
    sys.exit(exit_code)


"""
admin_or_root

Checks for adminstrator or root priviledges.

return True  : Sufficent priviledges.
return False : Insufficent priviledges.
"""
def admin_or_root():
    auth = False
    if (os.geteuid() == 0):
        auth = True

    return auth


"""
ask_name

Asks the user for names for different purposes with validation for each
sort of purpose.

return string : A valid string with it's first letter capitalized per
the given purpose.
"""
def ask_name(purpose):
    ask  = True
    name = ''

    def valid(test_name, purpose):
        return True

    while (ask):
        name = str(raw_input('What is the Name of your '+purpose.capitalize()+'?\n--> '))

        if (valid(name, purpose)):
            ask = False
        else:
            print('Invalid Project Name')

    return name


"""
set_apache_locations

Finds the needed Apache configuration locations/files, and stores them
in the configuration dict.
"""
def set_apache_locations(config):
    if (config['platform'] == 'linux'):
        if (config['dist'] == 'ubuntu' or config['dist'] == 'debian'):
            config['apache_conf'] = os.path.abspath('/etc/apache2/apache2.conf')
            config['vhost_dir'] = os.path.abspath('/etc/apache2/sites-available')


"""
ask_db_config

Ask user for MySQL database Setup.

return dict : Containing necessary database configuration values.
return dict : Empty, no database is to be configured.
"""
def ask_db_config():
    return



if __name__ == '__main__':
    main()
