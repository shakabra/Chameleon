#!/usr/bin/env python
import platform


"""
main

Configures a new Chameleon project and performs the setup of its Apache
virtual host and rewrite module.

return 0 : success
return 1 : general fail
"""
def main():
    exit_code = 0
    config = {}

    config['platform']     = platform.system().lower()
    config['proj_name']    = ask_name('project');
    config['default_view'] = ask_name('view');
    print (config)
    
    # Create a Virtual Host for Project.
    
    # See About Enabling Rewrite Module.

    # Create a git Branch

    # Create Config for the Project.
    
    return exit_code


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
ask_db_config

Ask user for MySQL database Setup.

return dict : Containing necessary database configuration values.
return dict : Empty, no database is to be configured.
"""
def ask_db_config():
    return



if __name__ == '__main__':
    main()
