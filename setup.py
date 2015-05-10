#!/usr/bin/env python
import platform


"""
main


"""
def main():
    config = {}

    config['platform']     = platform.system().lower()
    config['proj_name']    = ask_name('project');
    config['default_view'] = ask_name('view');
    print (config)
    
    # Create a Virtual Host for Project.
    
    # See About Enabling Rewrite Module.

    # Create a git Branch

    # Create Config for the Project.
    return


"""
Ask User for Project Name.
Ask User for Default Page Name.
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

Ask User for Database Setup.
"""
def ask_db_config():
    return



if __name__ == '__main__':
    main()
