#!/usr/bin/env python
import os
import sys
import platform
import re
import socket


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
        create_vhost(config)
        print (config)
    else:
        print('Insufficent Priviledges\nPlease run as root or admin user.')
        exit_code = 5
    
    
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

    while (ask):
        name = str(raw_input('What is the Name of your '+purpose.capitalize()+'?\n--> '))

        if (valid(name, 'name')):
            ask = False
        else:
            print('Invalid Project Name')

    return name


"""
valid

Used to validate user responses (strings)
for a given purpose (purpose).

param string
param purpose

return True  :
return False :
"""
def valid(string, purpose):
    response = True
    if (purpose == 'name'):
        NAME_MAX = 255; 
        response = 1<=len(string)<= NAME_MAX and "/" not in string and "\000" not in string

    if (purpose == 'ip'):
        try: 
            socket.inet_aton(string)
        except socket.error:
            response = False

    if (purpose == 'email'):
        if re.match(r"[^@]+@[^@]+\.[^@]+", string) is None:
            response = False

    if (purpose == 'path'):
        NAME_MAX = 255; 
        response = 1<=len(string)<= NAME_MAX and  "\000" not in string

    return response

"""
set_apache_locations

Finds the needed Apache configuration locations/files, and stores them
in the configuration dict.

param config {} : Necessary configuration data.
return True  : Successfully set Apache locations into config.
return False : Failed to set Apache locations into config.
"""
def set_apache_locations(config):
    if (config['platform'] == 'linux'):
        if (config['dist'] == 'ubuntu' or config['dist'] == 'debian'):
            config['apache_conf'] = os.path.abspath('/etc/apache2/apache2.conf')
            config['vhost_dir'] = os.path.abspath('/etc/apache2/sites-available')


"""
create_vhost

Create an Apache virtual host for the project.
"""
def create_vhost(config):
    vhost       = ''
    ip          = '*'
    admin       = 'webmaster@localhost'
    name        = ''
    locale      = ''
    vhost_file  = open(config['vhost_dir']+'/'+config['proj_name']+'.conf', 'w')

    # Strings we need to use for the UI:
    ask_about_ip      = 'Project requires specification of IP address? [y|n]\n--> '
    ask_for_ip        = 'What IP would you like to use?\n--> '
    ask_about_admin   = 'Would you like to specify a ServerAdmin? [y|n]\n--> '
    ask_for_admin     = 'What email would you like to set as ServerAdmin?\n--> '
    ask_for_name      = 'What is the ServerName?\n--> '
    ask_for_locale    = 'In which directory is the project located?\n--> '
    ip_validation_err = '! IP address given is not valid !'
    name_error        = '! Name given is not valid !'
    filesystem_error  = '! Not a Valid !'

    # Ask the things:
    if (raw_input(ask_about_ip)[0].lower() == 'y'):
        ip = raw_input(ask_for_ip)
        while not valid(ip, 'ip'):
            print ip_validation_error
            ip = raw_input(ask_for_ip)

    if (raw_input(ask_about_admin)[0].lower() == 'y'):
        ip = raw_input(ask_for_admin)
        while not valid(admin, 'name'):
            print name_error
            ip = raw_input(ask_for_ip)
    
    name = raw_input(ask_for_name)
    while not valid(name, 'name'):
        print name_error
        name = raw_input(ask_for_name)

    locale = raw_input(ask_for_locale)
    while not valid(locale, 'path'):
        print filesystem_error
        name = raw_input(ask_for_name)

    # Write the virtual host to memory:
    vhost  = '<VirtualHost '+ip+':80>\n'
    vhost += '\tServerAdmin '+admin+'\n'
    vhost += '\tServerName '+name+'\n'
    vhost += '\tDirectoryRoot '+locale+'\n'
    vhost += '</VirtualHost>\n'

    # Dump vhost to the vhost file:
    vhost_file.write(vhost)
    vhost_file.close()


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
